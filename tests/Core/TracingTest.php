<?php

namespace Tests\Core;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\RequestOptions;
use Anthropic\SSEStream;
use Nyholm\Psr7\Response;
use OpenTelemetry\API\Instrumentation\Configurator;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanContextInterface;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\ContextInterface;
use OpenTelemetry\Context\Propagation\PropagationGetterInterface;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;
use OpenTelemetry\Context\ScopeInterface;
use OpenTelemetry\SDK\Trace\Sampler\AlwaysOffSampler;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Writes the W3C trace context, and counts how often the SDK asks it to.
 */
final class CountingPropagator implements TextMapPropagatorInterface
{
    public int $injected = 0;

    public function fields(): array
    {
        return TraceContextPropagator::getInstance()->fields();
    }

    public function inject(mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null): void
    {
        ++$this->injected;
        TraceContextPropagator::getInstance()->inject($carrier, $setter, $context);
    }

    public function extract(mixed $carrier, ?PropagationGetterInterface $getter = null, ?ContextInterface $context = null): ContextInterface
    {
        return TraceContextPropagator::getInstance()->extract($carrier, $getter, $context);
    }
}

/**
 * Keeps the context of the span that is current while each request is sent.
 */
final class RecordingTransporter extends \Http\Mock\Client
{
    /** @var list<SpanContextInterface> */
    public array $current = [];

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->current[] = Span::getCurrent()->getContext();

        return parent::sendRequest($request);
    }
}

/**
 * @internal
 */
#[CoversNothing]
class TracingTest extends TestCase
{
    private const ENABLED_ENV = 'ANTHROPIC_OPEN_TELEMETRY';

    private const PROPAGATION_ENV = 'ANTHROPIC_OPEN_TELEMETRY_PROPAGATION';

    private CountingPropagator $propagator;

    private InMemoryExporter $exporter;

    private TracerProvider $recording;

    /** @var list<ScopeInterface> */
    private array $scopes = [];

    /** @var array<string, string|false> */
    private array $env = [];

    /** @var array<mixed> */
    private array $superglobal = [];

    protected function setUp(): void
    {
        $this->superglobal = $_ENV;
        foreach ([self::ENABLED_ENV, self::PROPAGATION_ENV] as $name) {
            $this->env[$name] = getenv($name);
            putenv($name);
            // The SDK reads $_ENV first, and putenv() does not change it.
            unset($_ENV[$name]);
        }
        $this->propagator = new CountingPropagator;
        $this->exporter = new InMemoryExporter;
        $this->recording = new TracerProvider(new SimpleSpanProcessor($this->exporter));
        $this->scopes[] = Configurator::create()->withPropagator($this->propagator)->activate();
    }

    protected function tearDown(): void
    {
        foreach (array_reverse($this->scopes) as $scope) {
            $scope->detach();
        }
        foreach ($this->env as $name => $value) {
            putenv(false === $value ? $name : "{$name}={$value}");
        }
        $_ENV = $this->superglobal;
    }

    #[DataProvider('tracerProviders')]
    public function testBothAttemptsCarryTheTraceContextUnlessPropagationIsOff(string $name, bool $propagation): void
    {
        $provider = match ($name) {
            'recording' => $this->recording,
            'sampled out' => new TracerProvider(new SimpleSpanProcessor($this->exporter), new AlwaysOffSampler),
            default => null,
        };
        $transporter = new RecordingTransporter;
        $option = [...(null === $provider ? [] : ['tracerProvider' => $provider]), ...($propagation ? [] : ['propagation' => false])];
        // Without a tracer provider the call has no span, and so no trace context to send.
        $headers = $propagation && null !== $provider;

        $this->assertSame([$headers, $headers], self::attempts(self::client($transporter, $option), $transporter));
        $this->assertSame($propagation, $this->propagator->injected > 0, 'the propagator is asked only by a client that propagates');

        // The spans are the same with or without the headers: the call span is current while each attempt is sent, also when it does not record, so that the application's HTTP instrumentation continues its trace.
        $this->assertCount('recording' === $name ? 1 : 0, $this->spans());
        foreach ($this->spans() as $span) {
            $this->assertTrue($span->hasEnded());
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        }
        $this->assertCount(2, $transporter->current);
        foreach ($transporter->current as $current) {
            $this->assertSame(null !== $provider, $current->isValid());
            $this->assertSame('recording' === $name, $current->isSampled());
        }
        $this->assertSame($transporter->current[0]->getSpanId(), $transporter->current[1]->getSpanId(), 'one span for both attempts');
    }

    /**
     * A span that records, one that a sampler drops, and none: the application has registered no tracer provider.
     *
     * @return iterable<string, array{string, bool}>
     */
    public static function tracerProviders(): iterable
    {
        foreach (['recording', 'sampled out', 'no tracer provider'] as $name) {
            yield "{$name}, propagation on" => [$name, true];

            yield "{$name}, propagation off" => [$name, false];
        }
    }

    /**
     * @param array<string, mixed>|null $option
     */
    #[DataProvider('propagationSettings')]
    public function testPropagationVariableAppliesOnlyToClientGivenNoOption(?array $option, string $variable, bool $headers): void
    {
        $this->registerTracerProvider();
        putenv(self::PROPAGATION_ENV."={$variable}");
        $transporter = new \Http\Mock\Client;

        $this->assertSame([$headers, $headers], self::attempts(self::client($transporter, $option), $transporter));
    }

    /**
     * The client's option, the value of the variable, and whether the requests carry the trace context.
     *
     * @return iterable<string, array{array<string, mixed>|null, string, bool}>
     */
    public static function propagationSettings(): iterable
    {
        yield 'the variable set to false' => [null, 'false', false];

        yield 'the variable in another case' => [null, 'FALSE', false];

        yield 'another value of the variable is ignored' => [null, '0', true];

        yield 'an empty option does not read the variable' => [[], 'false', true];

        yield 'true in code does not read the variable' => [['propagation' => true], 'false', true];

        yield 'false in code does not read the variable' => [['propagation' => false], 'true', false];

        yield 'null in code is the default, not the variable' => [['propagation' => null], 'false', true];
    }

    public function testPropagationVariableIsReadWhenClientIsBuilt(): void
    {
        $this->registerTracerProvider();
        $transporter = new \Http\Mock\Client;
        putenv(self::PROPAGATION_ENV.'=false');
        $quiet = self::client($transporter, null);
        putenv(self::PROPAGATION_ENV);

        $this->assertSame([false, false], self::attempts($quiet, $transporter));
        $this->assertSame([true, true], self::attempts(self::client($transporter, null), $transporter), 'on by default');
    }

    public function testClientGivenNoOptionReadsBothVariables(): void
    {
        $this->registerTracerProvider();
        putenv(self::ENABLED_ENV.'=false');
        putenv(self::PROPAGATION_ENV.'=false');
        $transporter = new \Http\Mock\Client;

        $this->assertSame([false, false], self::attempts(self::client($transporter, null), $transporter));
        $this->assertCount(0, $this->spans());
    }

    /**
     * @param array<string, mixed> $option
     */
    #[DataProvider('optionsThatSetNeitherVariable')]
    public function testClientGivenAnyOptionReadsNoVariable(bool $tracerProvider, array $option): void
    {
        $this->registerTracerProvider();
        putenv(self::ENABLED_ENV.'=false');
        putenv(self::PROPAGATION_ENV.'=false');
        $transporter = new \Http\Mock\Client;
        if ($tracerProvider) {
            $option['tracerProvider'] = $this->recording;
        }

        $this->assertSame([true, true], self::attempts(self::client($transporter, $option), $transporter));
        $this->assertCount(1, $this->spans());
    }

    /**
     * @return iterable<string, array{bool, array<string, mixed>}>
     */
    public static function optionsThatSetNeitherVariable(): iterable
    {
        yield 'an empty option' => [false, []];

        yield 'a tracer provider alone' => [true, []];

        yield 'traces set to true' => [false, ['traces' => true]];
    }

    #[DataProvider('propagation')]
    public function testRedirectOffTheOriginCarriesNoTraceContext(bool $propagation): void
    {
        $transporter = new \Http\Mock\Client;
        $transporter->addResponse(new Response(307, ['Location' => 'http://elsewhere.test/things/thing']));
        $transporter->addResponse(self::thing());

        self::call(self::client($transporter, ['tracerProvider' => $this->recording, 'propagation' => $propagation]))->parse();

        $this->assertCount(2, $transporter->getRequests());
        $redirected = $transporter->getRequests()[1];
        $this->assertSame('elsewhere.test', $redirected->getUri()->getHost());
        $this->assertFalse($redirected->hasHeader('traceparent'));
        $this->assertSame($propagation, $this->propagator->injected > 0, 'the propagator is asked only by a client that propagates');
    }

    /**
     * @return iterable<string, array{bool}>
     */
    public static function propagation(): iterable
    {
        yield 'propagation on' => [true];

        yield 'propagation off' => [false];
    }

    /**
     * @param \Closure(): mixed $build
     */
    #[DataProvider('invalidOptions')]
    public function testInvalidOptionIsRefused(string $key, \Closure $build): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($key);

        $build();
    }

    /**
     * The key that the exception names, and what has to throw it.
     *
     * @return iterable<string, array{string, \Closure(): mixed}>
     */
    public static function invalidOptions(): iterable
    {
        yield 'propagation as a string' => ["['propagation']", static fn () => self::client(new \Http\Mock\Client, ['propagation' => 'false'])];

        yield 'propagation of spans that are not enabled' => ["['propagation']", static fn () => self::client(new \Http\Mock\Client, ['traces' => false, 'propagation' => 0])];

        // @phpstan-ignore-next-line argument.type
        yield 'propagation as a request option' => ["'propagation'", static fn () => RequestOptions::with(openTelemetry: ['propagation' => false])];

        // @phpstan-ignore-next-line argument.type
        yield 'conversationId as an integer' => ["['conversationId']", static fn () => RequestOptions::with(openTelemetry: ['conversationId' => 5])];
    }

    public function testConversationIdIsAStringOrNull(): void
    {
        foreach (['conversation', null] as $id) {
            $this->assertSame(['conversationId' => $id], RequestOptions::with(openTelemetry: ['conversationId' => $id])->openTelemetry);
        }
    }

    public function testDroppedRawResponseEndsItsSpanOk(): void
    {
        $this->assertSame(StatusCode::STATUS_OK, $this->statusOfDropped(self::thing()));
    }

    public function testDroppedRawResponseOfStreamingCallEndsItsSpanWithNoStatus(): void
    {
        $events = new Response(200, ['Content-Type' => 'text/event-stream'], "data: {\"message\":\"hello\"}\n\n");

        // The application never read the stream: a cancellation.
        $this->assertSame(StatusCode::STATUS_UNSET, $this->statusOfDropped($events, SSEStream::class));
    }

    /**
     * @return list<SpanDataInterface>
     */
    private function spans(): array
    {
        // The exporter's own return type is a bare array.
        // @phpstan-ignore-next-line return.type
        return $this->exporter->getSpans();
    }

    /**
     * Registers the recording tracer provider, which gets the spans of a client that is given none.
     */
    private function registerTracerProvider(): void
    {
        $this->scopes[] = Configurator::create()->withPropagator($this->propagator)->withTracerProvider($this->recording)->activate();
    }

    /**
     * The status of the span of an API call whose raw response the application drops unparsed.
     *
     * @param class-string<BaseStream<mixed>>|null $stream
     */
    private function statusOfDropped(ResponseInterface $response, ?string $stream = null): string
    {
        $transporter = new \Http\Mock\Client;
        $transporter->addResponse($response);

        $raw = self::call(self::client($transporter, ['tracerProvider' => $this->recording]), $stream);
        $this->assertCount(0, $this->spans(), 'the span of a raw response is open while the application holds it');
        unset($raw);
        $this->assertCount(1, $this->spans(), 'dropping a raw response ends its span');

        return $this->spans()[0]->getStatus()->getCode();
    }

    /**
     * @param array<string, mixed>|false|null $openTelemetry
     */
    private static function client(\Http\Mock\Client $transporter, array|false|null $openTelemetry): Client
    {
        // Some tests pass what the option's type rules out.
        // @phpstan-ignore-next-line argument.type
        return new Client(baseUrl: 'http://localhost', apiKey: 'my-anthropic-api-key', requestOptions: ['transporter' => $transporter, 'maxRetries' => 1], openTelemetry: $openTelemetry);
    }

    /**
     * An API call as an SDK method makes it: its name is what gives it a span.
     *
     * @param class-string<BaseStream<mixed>>|null $stream
     *
     * @return BaseResponse<mixed>
     */
    private static function call(Client $client, ?string $stream = null): BaseResponse
    {
        return $client->request(method: 'get', path: 'things/thing', stream: $stream, options: RequestOptions::parse()->withApiCall(new ApiCallInfo(name: 'things.retrieve')));
    }

    private static function thing(): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'application/json'], '{"id":"thing"}');
    }

    /**
     * One API call whose first attempt fails, so that it sends two requests. Says whether each carried the trace context.
     *
     * @return list<bool>
     */
    private static function attempts(Client $client, \Http\Mock\Client $transporter): array
    {
        $transporter->addResponse(new Response(500, ['retry-after-ms' => '1']));
        $transporter->addResponse(self::thing());
        $sent = count($transporter->getRequests());
        self::call($client)->parse();

        return array_values(array_map(static fn (RequestInterface $request): bool => $request->hasHeader('traceparent'), array_slice($transporter->getRequests(), $sent)));
    }
}
