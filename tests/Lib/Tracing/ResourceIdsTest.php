<?php

declare(strict_types=1);

namespace Tests\Lib\Tracing;

use Anthropic\Client;
use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\RateLimitException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use OpenTelemetry\SDK\Trace\ImmutableSpan;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * The resource IDs of every SDK method whose request has a parameter in its path, or that creates an object.
 * `resource_ids.json` lists them: the method, the arguments that go into the path with the attribute of each, and
 * the attribute and response field of the ID of a created object.
 *
 * @phpstan-type Operation = array{
 *   span: string,
 *   http_method: string,
 *   url: string,
 *   service: class-string,
 *   method: string,
 *   positional: list<string>,
 *   keywords: list<string>,
 *   path: array<string, string>,
 *   created: array{attribute: string, field: string}|null,
 *   list: bool,
 *   stream: bool,
 * }
 *
 * @internal
 */
#[CoversNothing]
final class ResourceIdsTest extends TestCase
{
    private InMemoryExporter $exporter;

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new InMemoryExporter;
        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
            openTelemetry: ['tracerProvider' => new TracerProvider(new SimpleSpanProcessor($this->exporter))],
        );
    }

    /**
     * @param Operation $operation
     */
    #[DataProvider('operations')]
    public function testSpanHasTheIdsOfThePathAndOfTheCreatedObject(array $operation): void
    {
        $created = $operation['created'];
        $expected = [];
        foreach ($operation['path'] as $argument => $attribute) {
            $expected[$attribute] = "{$argument}_value";
        }

        $this->transporter->addResponse(match (true) {
            $operation['stream'] => self::response('', 'text/event-stream'),
            $operation['list'] => self::response(['data' => [['id' => 'item_1']], 'has_more' => true, 'first_id' => 'item_1', 'last_id' => 'item_1', 'next_page' => 'page_2']),
            // A membership has the ID in a field like `user_id`, and no `id`.
            null !== $created => self::response([$created['field'] => 'created_1']),
            default => self::response(['id' => 'not_a_created_object']),
        });
        $result = $this->call($operation)->parse();

        if ($result instanceof BaseStream) {
            foreach ($result as $_);
        }
        if ($operation['list']) {
            // The request for a later page repeats the first one, so its span has the IDs of the path too.
            $this->assertInstanceOf(BasePage::class, $result);
            $this->transporter->addResponse(self::response(['data' => [], 'has_more' => false]));
            $result->getNextPage();
            $this->assertCount(2, $this->spans());
        }
        // `url` is the path with each parameter by the name of its argument. The route has it by the name the API gives it.
        $path = '/'.explode('?', $operation['url'])[0];
        foreach ($this->spans() as $span) {
            $this->assertSame($operation['span'], $span->getName());
            $this->assertSame($expected + (null === $created ? [] : [$created['attribute'] => 'created_1']), self::ids($span));
            // A call to a Session thread is in the conversation of that thread. Any other names none.
            $this->assertSame($expected['anthropic.session.thread.id'] ?? null, $span->getAttributes()->get('gen_ai.conversation.id'));
            $this->assertSame(strtoupper($operation['http_method']), $span->getAttributes()->get('http.request.method'));
            $route = $span->getAttributes()->get('http.route');
            $this->assertIsString($route);
            $this->assertSame(preg_replace('/\{\w+\}/', '{}', $path), preg_replace('/\{[a-z_]+\}/', '{}', $route));
            $this->assertSame(preg_replace('/\{(\w+)\}/', '$1_value', $path), $span->getAttributes()->get('url.path'));
        }

        if (null !== $created) {
            // A failed create has the IDs of its path, and none of an object it did not create.
            $this->transporter->addResponse(self::response(['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']], status: 429));

            try {
                $this->call($operation)->parse();
                $this->fail('expected a RateLimitException');
            } catch (RateLimitException) {
            }
            $failed = array_slice($this->spans(), -1);
            $this->assertCount(1, $failed);
            $this->assertSame($expected, self::ids($failed[0]));
        }
    }

    /**
     * @return iterable<string, array{Operation}>
     */
    public static function operations(): iterable
    {
        $document = json_decode((string) file_get_contents(__DIR__.'/resource_ids.json'), true, flags: JSON_THROW_ON_ERROR);
        self::assertIsArray($document);
        self::assertIsArray($document['operations']);
        self::assertGreaterThan(100, count($document['operations']));

        /** @var Operation $operation */
        foreach ($document['operations'] as $operation) {
            yield "{$operation['http_method']} {$operation['url']}" => [$operation];
        }
    }

    /**
     * Calls the method of `$operation` on its raw service, with `<name>_value` for each argument that goes into
     * the path.
     *
     * @param Operation $operation
     *
     * @return BaseResponse<mixed>
     */
    private function call(array $operation): BaseResponse
    {
        $service = new $operation['service']($this->client);
        $arguments = [];
        foreach ((new \ReflectionMethod($service, $operation['method']))->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (in_array($name, $operation['positional'], true)) {
                $arguments[$name] = "{$name}_value";
            } elseif ('params' === $name) {
                $arguments[$name] = [];
                foreach ($operation['keywords'] as $keyword) {
                    $arguments[$name][$keyword] = "{$keyword}_value";
                }
            }
        }
        $response = $service->{$operation['method']}(...$arguments);
        $this->assertInstanceOf(BaseResponse::class, $response);

        return $response;
    }

    /**
     * The attributes of `$span` that hold a resource ID.
     *
     * @return array<string, mixed>
     */
    private static function ids(ImmutableSpan $span): array
    {
        $ids = [];
        foreach ($span->getAttributes()->toArray() as $name => $value) {
            if (is_string($name) && str_ends_with($name, '.id') && !in_array($name, ['anthropic.request.id', 'anthropic.organization.id', 'anthropic.workspace.id', 'gen_ai.response.id', 'gen_ai.conversation.id'], true)) {
                $ids[$name] = $value;
            }
        }

        return $ids;
    }

    /**
     * @return list<ImmutableSpan>
     */
    private function spans(): array
    {
        $spans = [];
        foreach ($this->exporter->getSpans() as $span) {
            $this->assertInstanceOf(ImmutableSpan::class, $span);
            $spans[] = $span;
        }

        return $spans;
    }

    /**
     * @param array<string, mixed>|string $body
     */
    private static function response(array|string $body, string $contentType = 'application/json', int $status = 200): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', $contentType)
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(is_string($body) ? $body : json_encode($body, JSON_THROW_ON_ERROR)))
        ;
    }
}
