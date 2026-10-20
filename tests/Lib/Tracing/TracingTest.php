<?php

declare(strict_types=1);

namespace Tests\Lib\Tracing;

use Anthropic\Aws;
use Anthropic\Bedrock;
use Anthropic\Bedrock\MantleClient;
use Anthropic\Beta\Messages\BetaJSONOutputFormat;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams;
use Anthropic\Client;
use Anthropic\Core\Concerns\ResponseProxy;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Exceptions\RateLimitException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Foundry;
use Anthropic\GoogleCloud;
use Anthropic\Lib\Tools\BetaMcp;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Anthropic\Lib\Tools\BetaToolRunner;
use Anthropic\Lib\Tracing\Content;
use Anthropic\Lib\Tracing\Tracing;
use Anthropic\RequestOptions;
use Anthropic\SSEStream;
use Anthropic\Vertex;
use Http\Client\Exception\NetworkException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use Mcp\Client as McpClient;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Schema\Tool as McpTool;
use OpenTelemetry\API\Baggage\Baggage;
use OpenTelemetry\API\Baggage\Propagation\BaggagePropagator;
use OpenTelemetry\API\Instrumentation\Configurator;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanContext;
use OpenTelemetry\API\Trace\SpanContextInterface;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TraceFlags;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\API\Trace\TraceState;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextInterface;
use OpenTelemetry\Context\Propagation\MultiTextMapPropagator;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;
use OpenTelemetry\Context\ScopeInterface;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Trace\ImmutableSpan;
use OpenTelemetry\SDK\Trace\ReadableSpanInterface;
use OpenTelemetry\SDK\Trace\ReadWriteSpanInterface;
use OpenTelemetry\SDK\Trace\Sampler\AlwaysOffSampler;
use OpenTelemetry\SDK\Trace\SamplerInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\SpanProcessorInterface;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use const Anthropic\VERSION;

/**
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 * @phpstan-import-type Part from \Anthropic\Lib\Tracing\Content
 * @phpstan-import-type InputMessage from \Anthropic\Lib\Tracing\Content
 * @phpstan-import-type OutputMessage from \Anthropic\Lib\Tracing\Content
 *
 * @phpstan-type MessageContent = array{system: list<Part>|null, input: list<InputMessage>|null, output: list<OutputMessage>|null, stopSequences?: list<string>|null}
 *
 * @internal
 */
#[CoversNothing]
final class TracingTest extends TestCase
{
    private const MESSAGE = [
        'id' => 'msg_1',
        'type' => 'message',
        'role' => 'assistant',
        'model' => 'claude-test-20260101',
        'content' => [['type' => 'text', 'text' => 'Hi there']],
        'stop_reason' => 'end_turn',
        'stop_sequence' => null,
        'usage' => [
            'input_tokens' => 10,
            'cache_read_input_tokens' => 2,
            'cache_creation_input_tokens' => 3,
            'cache_creation' => ['ephemeral_5m_input_tokens' => 1, 'ephemeral_1h_input_tokens' => 2],
            'output_tokens' => 5,
            'service_tier' => 'standard',
        ],
    ];

    private const SESSION = [
        'id' => 'sesn_1',
        'type' => 'session',
        'agent' => ['id' => 'agent_1', 'type' => 'agent', 'name' => 'Researcher', 'version' => 2, 'model' => ['id' => 'claude-test-20260101']],
        'environment_id' => 'env_1',
    ];

    private InMemoryExporter $exporter;

    private TracerProvider $tracerProvider;

    private MockClient $transporter;

    private ScopeInterface $scope;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new InMemoryExporter;
        $this->tracerProvider = new TracerProvider(new SimpleSpanProcessor($this->exporter));
        $this->transporter = new MockClient;
        // The application's propagator, as an OpenTelemetry SDK would register it.
        $this->scope = Configurator::create()->withPropagator(TraceContextPropagator::getInstance())->activate();
        putenv('ANTHROPIC_OPEN_TELEMETRY');
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES');
        putenv('ANTHROPIC_OPEN_TELEMETRY_CONTENT_MODE');
    }

    protected function tearDown(): void
    {
        $this->scope->detach();
        putenv('ANTHROPIC_OPEN_TELEMETRY');
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES');
        putenv('ANTHROPIC_OPEN_TELEMETRY_CONTENT_MODE');

        parent::tearDown();
    }

    public function testUnaryCallEmitsClientSpanWithGenAIAttributes(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE, headers: ['request-id' => 'req_123', 'anthropic-organization-id' => 'org_1']));

        $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', temperature: 0.5);

        $span = $this->onlySpan();
        $this->assertSame('anthropic.messages.create', $span->getName());
        $this->assertSame(SpanKind::KIND_CLIENT, $span->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $this->assertSame('com.anthropic.sdk.php', $span->getInstrumentationScope()->getName());
        $this->assertSame(VERSION, $span->getInstrumentationScope()->getVersion());

        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('chat', $attributes['gen_ai.operation.name']);
        $this->assertSame('anthropic', $attributes['gen_ai.provider.name']);
        $this->assertSame('claude-test', $attributes['gen_ai.request.model']);
        $this->assertSame(16, $attributes['gen_ai.request.max_tokens']);
        $this->assertSame(0.5, $attributes['gen_ai.request.temperature']);
        $this->assertSame('claude-test-20260101', $attributes['gen_ai.response.model']);
        $this->assertSame('msg_1', $attributes['gen_ai.response.id']);
        $this->assertSame(15, $attributes['gen_ai.usage.input_tokens']);
        $this->assertSame(5, $attributes['gen_ai.usage.output_tokens']);
        $this->assertSame(3, $attributes['gen_ai.usage.cache_write.input_tokens']);
        $this->assertSame(2, $attributes['gen_ai.usage.cache_read.input_tokens']);
        $this->assertSame(1, $attributes['anthropic.usage.cache_creation.ephemeral_5m_input_tokens']);
        $this->assertSame('end_turn', $attributes['anthropic.message.stop_reason']);
        $this->assertArrayNotHasKey('gen_ai.response.finish_reasons', $attributes);
        $this->assertSame('standard', $attributes['anthropic.response.service_tier']);
        $this->assertSame('api.example.test', $attributes['server.address']);
        $this->assertSame(8443, $attributes['server.port']);
        $this->assertSame(200, $attributes['http.response.status_code']);
        $this->assertSame('POST', $attributes['http.request.method']);
        $this->assertSame('/v1/messages', $attributes['http.route']);
        $this->assertSame('https', $attributes['url.scheme']);
        $this->assertSame('/v1/messages', $attributes['url.path']);
        $this->assertSame('https://api.example.test:8443/v1/messages', $attributes['url.full']);
        $this->assertArrayNotHasKey('url.query', $attributes);
        // A call that sends a single request has no resend count, rather than a count of zero.
        $this->assertArrayNotHasKey('http.request.resend_count', $attributes);
        foreach (['network.peer.address', 'network.peer.port', 'network.protocol.version'] as $name) {
            $this->assertArrayNotHasKey($name, $attributes);
        }
        $this->assertSame('req_123', $attributes['anthropic.request.id']);
        $this->assertSame('org_1', $attributes['anthropic.organization.id']);
        $this->assertArrayNotHasKey('gen_ai.request.stream', $attributes);
        $this->assertArrayNotHasKey('gen_ai.input.messages', $attributes);
        $this->assertArrayNotHasKey('anthropic.content.truncated', $attributes);
        $this->assertArrayNotHasKey('error.type', $attributes);
    }

    public function testStreamClosedEarlyStaysUnsetAndKeepsMessageStartAttributes(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents(stop: false)));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event) {
            if ('content_block_delta' === $event->type) {
                $stream->close();

                break;
            }
        }

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertTrue($attributes['gen_ai.request.stream']);
        $this->assertSame('msg_1', $attributes['gen_ai.response.id']);
        $this->assertSame('standard', $attributes['anthropic.response.service_tier']);
        $this->assertSame(15, $attributes['gen_ai.usage.input_tokens']);
        $this->assertArrayNotHasKey('gen_ai.usage.output_tokens', $attributes);
        $this->assertArrayNotHasKey('anthropic.message.stop_reason', $attributes);
        $this->assertArrayNotHasKey('error.type', $attributes);
    }

    public function testStreamReadToTheEndIsOk(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame(7, $attributes['gen_ai.usage.output_tokens']);
        $this->assertSame('end_turn', $attributes['anthropic.message.stop_reason']);
        $this->assertIsFloat($attributes['gen_ai.response.time_to_first_chunk']);
    }

    public function testStreamThatAFallbackModelTakesOverReportsThatModel(): void
    {
        $fallback = ['type' => 'fallback', 'from' => ['model' => 'claude-test-20260101'], 'to' => ['model' => 'claude-fallback-20260101'], 'trigger' => ['type' => 'refusal', 'category' => 'cyber']];
        $this->transporter->addResponse(self::sse([
            self::streamEvents()[0],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => $fallback],
            ['type' => 'content_block_stop', 'index' => 0],
            ['type' => 'content_block_start', 'index' => 1, 'content_block' => ['type' => 'text', 'text' => '']],
            ['type' => 'content_block_delta', 'index' => 1, 'delta' => ['type' => 'text_delta', 'text' => 'Hi']],
            ['type' => 'content_block_stop', 'index' => 1],
            ...array_slice(self::streamEvents(), -2),
        ]));

        $stream = $this->client()->beta->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('claude-test', $attributes['gen_ai.request.model']);
        $this->assertSame('claude-fallback-20260101', $attributes['gen_ai.response.model']);
    }

    public function testCompactionTokensAreTheirOwnAttributesAndNoPartOfTheUsage(): void
    {
        $iteration = static fn (string $type, int $input, int $cacheRead, int $cacheCreation, int $output): array => ['type' => $type, 'input_tokens' => $input, 'cache_read_input_tokens' => $cacheRead, 'cache_creation_input_tokens' => $cacheCreation, 'cache_creation' => null, 'output_tokens' => $output];
        $iterations = [$iteration('compaction', 100, 20, 3, 40), $iteration('message', 10, 2, 3, 5), $iteration('compaction', 200, 0, 0, 60)];
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $delta = ['type' => 'message_delta', 'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7, 'iterations' => $iterations]];

        // The counts are no content: every content mode has them.
        foreach ([$this->client(), $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])] as $client) {
            $before = count($this->spans());
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'usage' => [...self::MESSAGE['usage'], 'iterations' => $iterations]]));
            $client->beta->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');
            // A response whose only sampling step is a compaction has no usage of its own.
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'usage' => ['input_tokens' => 0, 'output_tokens' => 0, 'iterations' => [$iteration('compaction', 50, 0, 0, 9)]]]));
            $client->beta->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');
            $this->transporter->addResponse(self::sse([...array_slice(self::streamEvents(), 0, 4), $delta, ['type' => 'message_stop']]));
            foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
            // A stream that the server ends after `message_delta` and before `message_stop` keeps what `message_delta` brought.
            $this->transporter->addResponse(self::sse([...array_slice(self::streamEvents(), 0, 4), $delta]));
            foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
            // One that the server ends before `message_delta` has only the usage of `message_start`, whose output tokens are a placeholder.
            $this->transporter->addResponse(self::sse(array_slice(self::streamEvents(), 0, 4)));
            foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
            foreach ([null, [], [$iteration('message', 10, 2, 3, 5)]] as $none) {
                $this->transporter->addResponse(self::json([...self::MESSAGE, 'usage' => [...self::MESSAGE['usage'], 'iterations' => $none]]));
                $client->beta->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');
            }
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $client->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');

            $spans = array_slice($this->spans(), $before);
            $this->assertCount(9, $spans);
            $expected = [[323, 100, 15, 5], [50, 9, 0, 0], [323, 100, 15, 7], [323, 100, 15, 7], [null, null, 15, null]];
            foreach ($spans as $index => $span) {
                $attributes = $span->getAttributes()->toArray();
                [$compactionInput, $compactionOutput, $input, $output] = $expected[$index] ?? [null, null, 15, 5];
                $this->assertSame($compactionInput, $attributes['anthropic.usage.compaction.input_tokens'] ?? null, (string) $index);
                $this->assertSame($compactionOutput, $attributes['anthropic.usage.compaction.output_tokens'] ?? null, (string) $index);
                $this->assertSame($input, $attributes['gen_ai.usage.input_tokens'], (string) $index);
                $this->assertSame($output, $attributes['gen_ai.usage.output_tokens'] ?? null, (string) $index);
            }
            $this->assertSame(StatusCode::STATUS_ERROR, $spans[3]->getStatus()->getCode());
            $this->assertSame(StatusCode::STATUS_ERROR, $spans[4]->getStatus()->getCode());
        }
    }

    /**
     * The application closes the stream before the API does, so the call is canceled even though `message_stop` was read.
     */
    public function testStreamClosedAfterMessageStopStaysUnsetAndKeepsTheResponseAttributes(): void
    {
        $client = $this->client();
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        foreach ([$client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test'), $client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test')] as $stream) {
            foreach ($stream as $event) {
                if ('message_stop' === $event->type) {
                    $stream->close();

                    break;
                }
            }
        }

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
            $attributes = $span->getAttributes()->toArray();
            $this->assertArrayNotHasKey('error.type', $attributes);
            $this->assertSame(7, $attributes['gen_ai.usage.output_tokens']);
            $this->assertSame('end_turn', $attributes['anthropic.message.stop_reason']);
            $this->assertIsFloat($attributes['gen_ai.response.time_to_first_chunk']);
        }
    }

    public function testStreamDroppedAfterMessageStopEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event) {
            if ('message_stop' === $event->type) {
                break;
            }
        }
        $this->assertSame([], $this->spans());
        unset($stream, $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $this->assertNull($span->getAttributes()->get('error.type'));
        $this->assertSame('end_turn', $span->getAttributes()->get('anthropic.message.stop_reason'));
    }

    public function testStreamTheServerEndsBeforeMessageStopIsAnError(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents(stop: false)));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('api_error', $attributes['error.type']);
        $this->assertSame('msg_1', $attributes['gen_ai.response.id']);
        $this->assertArrayNotHasKey('gen_ai.usage.output_tokens', $attributes);
        $this->assertArrayNotHasKey('anthropic.message.stop_reason', $attributes);
    }

    /**
     * `message_delta` brings the stop reason and the output tokens, so a stream that ends after it keeps them, however it ends.
     */
    public function testStreamThatEndsAfterMessageDeltaAndBeforeMessageStopKeepsTheStopReasonAndTheOutputTokens(): void
    {
        $events = array_slice(self::streamEvents(), 0, 5);
        $events[4]['usage'] = ['output_tokens' => 7, 'output_tokens_details' => ['thinking_tokens' => 4]];
        $this->assertSame('message_delta', $events[4]['type']);
        $create = fn () => $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        // The server ends the stream.
        $this->transporter->addResponse(self::sse($events));
        foreach ($create() as $event);
        // The application closes it.
        $this->transporter->addResponse(self::sse([...$events, ['type' => 'message_stop']]));
        $stream = $create();
        foreach ($stream as $event) {
            if ('message_delta' === $event->type) {
                $stream->close();

                break;
            }
        }

        [$ended, $closed] = $this->spans();
        $this->assertSame(StatusCode::STATUS_ERROR, $ended->getStatus()->getCode());
        $this->assertSame('api_error', $ended->getAttributes()->get('error.type'));
        $this->assertSame(StatusCode::STATUS_UNSET, $closed->getStatus()->getCode());
        $this->assertNull($closed->getAttributes()->get('error.type'));
        foreach ([$ended, $closed] as $span) {
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame('end_turn', $attributes['anthropic.message.stop_reason']);
            $this->assertSame(7, $attributes['gen_ai.usage.output_tokens']);
            $this->assertSame(4, $attributes['gen_ai.usage.reasoning.output_tokens']);
            $this->assertSame(15, $attributes['gen_ai.usage.input_tokens']);
        }
    }

    /**
     * An event stream has no end event, so neither the server ending it nor the application closing it completes the call.
     */
    public function testEventStreamEndedByTheServerOrClosedEarlyIsUnset(): void
    {
        $events = [
            ['type' => 'session.status_running', 'id' => 'sevt_1', 'processed_at' => '2026-01-01T00:00:00Z'],
            ['type' => 'session.status_running', 'id' => 'sevt_2', 'processed_at' => '2026-01-01T00:00:01Z'],
        ];
        $this->transporter->addResponse(self::sse($events));
        $this->transporter->addResponse(self::sse($events));
        $client = $this->client();

        $stream = $client->beta->sessions->events->streamStream('sesn_1');
        $read = 0;
        foreach ($stream as $event) {
            ++$read;
        }
        $stream = $client->beta->sessions->events->streamStream('sesn_1');
        foreach ($stream as $event) {
            $stream->close();

            break;
        }

        $this->assertSame(2, $read);
        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame('anthropic.sessions.events.stream', $span->getName());
            $this->assertTrue($span->hasEnded());
            $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
            $this->assertNull($span->getAttributes()->get('error.type'));
        }
        $attributes = $spans[0]->getAttributes()->toArray();
        $this->assertSame('anthropic', $attributes['gen_ai.provider.name']);
        $this->assertSame('api.example.test', $attributes['server.address']);
        $this->assertSame(200, $attributes['http.response.status_code']);
    }

    public function testStreamDroppedPartWayEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event) {
            break;
        }
        $this->assertSame([], $this->spans());
        unset($stream, $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $this->assertSame('msg_1', $span->getAttributes()->get('gen_ai.response.id'));
    }

    public function testStreamThatNoVariableHoldsEndsItsSpanUnsetAfterABreak(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        foreach ($this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test') as $event) {
            break;
        }

        $this->assertSame(StatusCode::STATUS_UNSET, $this->onlySpan()->getStatus()->getCode());
    }

    public function testStreamClosedInsideItsLoopEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $read = 0;
        foreach ($stream as $event) {
            ++$read;
            $stream->close();
        }

        $this->assertSame(1, $read);
        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $this->assertNull($span->getAttributes()->get('error.type'));
    }

    public function testStreamClosedWhileItsIteratorIsHeldEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $client = $this->client();

        $unread = $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $unreadIterator = $unread->getIterator();
        $unread->close();
        $this->assertCount(1, $this->spans());
        $this->assertSame([], iterator_to_array($unreadIterator, false));

        $partRead = $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $partReadIterator = $partRead->getIterator();
        $partReadIterator->current();
        $partRead->close();

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
            $this->assertNull($span->getAttributes()->get('error.type'));
        }
    }

    public function testOnlyACallWithARecordingSpanReturnsAnotherStreamClass(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $sampledOut = ['tracerProvider' => new TracerProvider(sampler: new AlwaysOffSampler)];

        $traced = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $untraced = $this->client(false)->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $dropped = $this->client($sampledOut)->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        $this->assertNotInstanceOf(SSEStream::class, $traced);
        $this->assertCount(count(self::streamEvents()), iterator_to_array($traced, false));
        $this->assertInstanceOf(SSEStream::class, $untraced);
        $this->assertInstanceOf(SSEStream::class, $dropped);
    }

    public function testParsedStreamNeverReadEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $this->assertSame(200, $span->getAttributes()->get('http.response.status_code'));
    }

    public function testStreamClosedBeforeReadingEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $this->transporter->addResponse(self::sse(self::streamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $stream->close();

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $this->assertNull($span->getAttributes()->get('error.type'));
        $this->assertNull($span->getAttributes()->get('gen_ai.response.id'));
        $this->assertSame([], iterator_to_array($stream, false));

        // The same close with spans disabled reads nothing either.
        $stream = $this->client(false)->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $stream->close();
        $this->assertSame([], iterator_to_array($stream, false));
        $this->assertCount(1, $this->spans());
    }

    public function testStreamRetriedMeasuresTimeToFirstChunkFromTheFirstAttempt(): void
    {
        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'busy']], status: 529, headers: ['retry-after-ms' => '300']));
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 1], openTelemetry: ['tracerProvider' => $this->tracerProvider]);

        foreach ($client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test') as $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $this->assertGreaterThanOrEqual(0.3, $span->getAttributes()->get('gen_ai.response.time_to_first_chunk'));
    }

    /**
     * The first chunk is the first `content_block_delta`: neither the events before it nor the deltas after it count.
     */
    public function testTimeToFirstChunkRunsToTheFirstContentBlockDelta(): void
    {
        $events = self::toolUseStreamEvents();
        $this->transporter->addResponse(self::sse([$events[0], ['type' => 'ping'], ...array_slice($events, 1)]));

        // The SDK reads an event when the application asks for it, so a pause here delays the events that follow.
        $start = hrtime(true);
        $firstDelta = null;
        foreach ($this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test') as $event) {
            if ('message_start' === $event->type) {
                usleep(100_000);
            } elseif ('content_block_delta' === $event->type && null === $firstDelta) {
                $firstDelta = (hrtime(true) - $start) / 1e9;
                usleep(100_000);
            }
        }

        $time = $this->onlySpan()->getAttributes()->get('gen_ai.response.time_to_first_chunk');
        $this->assertIsFloat($time);
        $this->assertGreaterThanOrEqual(0.1, $time);
        // The application got the first delta after the span did, and the later deltas 0.1 s after that.
        $this->assertLessThanOrEqual($firstDelta, $time);
    }

    public function testStreamWithoutAContentBlockDeltaHasNoTimeToFirstChunk(): void
    {
        $client = $this->client();
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $withoutDeltas = array_values(array_filter(self::streamEvents(), static fn (array $event): bool => 'content_block_delta' !== $event['type']));

        // A response that has no delta, read to the end.
        $this->transporter->addResponse(self::sse($withoutDeltas));
        foreach ($client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
        $this->transporter->addResponse(self::sse($withoutDeltas));
        foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
        // A stream closed before its first delta.
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $stream = $client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test');
        foreach ($stream as $event) {
            if ('content_block_start' === $event->type) {
                $stream->close();

                break;
            }
        }

        $spans = $this->spans();
        $this->assertCount(3, $spans);
        foreach ($spans as $index => $span) {
            $this->assertSame(2 === $index ? StatusCode::STATUS_UNSET : StatusCode::STATUS_OK, $span->getStatus()->getCode(), (string) $index);
            $this->assertSame('msg_1', $span->getAttributes()->get('gen_ai.response.id'), (string) $index);
            $this->assertNull($span->getAttributes()->get('gen_ai.response.time_to_first_chunk'), (string) $index);
        }
    }

    /**
     * @param array<string, mixed> $block
     * @param array<string, mixed> $delta
     */
    #[DataProvider('contentBlockDeltaCases')]
    public function testContentBlockDeltaOfAnyTypeIsTheFirstChunk(array $block, array $delta): void
    {
        $client = $this->client();
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $events = [
            self::streamEvents()[0],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => $block],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => $delta],
            ['type' => 'content_block_stop', 'index' => 0],
            ...array_slice(self::streamEvents(), -2),
        ];

        $this->transporter->addResponse(self::sse($events));
        foreach ($client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
        $this->transporter->addResponse(self::sse($events));
        foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
            $this->assertIsFloat($span->getAttributes()->get('gen_ai.response.time_to_first_chunk'));
        }
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<string, mixed>}>
     */
    public static function contentBlockDeltaCases(): iterable
    {
        $text = ['type' => 'text', 'text' => ''];
        $thinking = ['type' => 'thinking', 'thinking' => '', 'signature' => ''];

        yield 'text_delta' => [$text, ['type' => 'text_delta', 'text' => 'Hi']];

        yield 'citations_delta' => [$text, ['type' => 'citations_delta', 'citation' => ['type' => 'char_location', 'cited_text' => 'Hi', 'document_index' => 0, 'document_title' => null, 'start_char_index' => 0, 'end_char_index' => 2, 'file_id' => null]]];

        yield 'input_json_delta' => [['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => new \stdClass], ['type' => 'input_json_delta', 'partial_json' => '{}']];

        yield 'thinking_delta' => [$thinking, ['type' => 'thinking_delta', 'thinking' => 'Hm']];

        yield 'signature_delta' => [$thinking, ['type' => 'signature_delta', 'signature' => 'sig']];

        yield 'a delta type this SDK version does not know' => [$text, ['type' => 'other_delta', 'other' => 'x']];
    }

    public function testBatchResultsSpanCoversTheDownload(): void
    {
        $this->transporter->addResponse(self::jsonl([self::batchResult('req_1'), self::batchResult('req_2')]));

        $results = $this->client()->messages->batches->resultsStream('msgbatch_1');
        $this->assertSame([], $this->spans());
        $ids = [];
        foreach ($results as $result) {
            $ids[] = $result->customID;
        }

        $this->assertSame(['req_1', 'req_2'], $ids);
        $span = $this->onlySpan();
        $this->assertSame('anthropic.messages.batches.results', $span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $this->assertSame('msgbatch_1', $span->getAttributes()->get('anthropic.message.batch.id'));
        $this->assertSame(200, $span->getAttributes()->get('http.response.status_code'));
    }

    public function testBatchResultsThatFailWhileReadingFailTheSpan(): void
    {
        $this->transporter->addResponse(self::jsonl([self::batchResult('req_1')], tail: "{\"custom_id\":\n"));

        $results = $this->client()->messages->batches->resultsStream('msgbatch_1');
        $ids = [];
        $thrown = null;

        try {
            foreach ($results as $result) {
                $ids[] = $result->customID;
            }
        } catch (\Exception $e) {
            $thrown = $e;
        }

        $this->assertInstanceOf(\JsonException::class, $thrown);
        $this->assertSame(['req_1'], $ids);
        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $this->assertSame('client_error', $span->getAttributes()->get('error.type'));
    }

    public function testBatchResultsClosedEarlyLeaveTheStatusUnset(): void
    {
        $this->transporter->addResponse(self::jsonl([self::batchResult('req_1'), self::batchResult('req_2')]));
        $this->transporter->addResponse(self::jsonl([self::batchResult('req_1'), self::batchResult('req_2')]));
        $client = $this->client();

        $client->messages->batches->resultsStream('msgbatch_1')->close();
        $results = $client->messages->batches->resultsStream('msgbatch_2');
        foreach ($results as $result) {
            $results->close();

            break;
        }

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
            $this->assertNull($span->getAttributes()->get('error.type'));
        }
    }

    public function testRawResponseLeftUnparsedEndsAtTheHeaders(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE, headers: ['request-id' => 'req_123']));

        $response = $this->client()->messages->raw->create(['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test']);
        $this->assertSame('req_123', $response->getRequestID());
        $this->assertSame([], $this->spans());
        unset($response);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame(200, $attributes['http.response.status_code']);
        $this->assertSame('req_123', $attributes['anthropic.request.id']);
        $this->assertSame('claude-test', $attributes['gen_ai.request.model']);
        $this->assertArrayNotHasKey('gen_ai.usage.output_tokens', $attributes);
    }

    public function testRawResponseOfAStreamingCallLeftUnparsedEndsItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents())->withHeader('request-id', 'req_123'));

        $response = $this->client()->messages->raw->createStream(['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test']);
        $this->assertSame([], $this->spans());
        unset($response);

        // The application never read the stream: a cancellation, as a parsed stream that is never read is.
        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_UNSET, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame(200, $attributes['http.response.status_code']);
        $this->assertSame('req_123', $attributes['anthropic.request.id']);
        $this->assertTrue($attributes['gen_ai.request.stream']);
        $this->assertArrayNotHasKey('error.type', $attributes);
    }

    public function testCallThatFailsOrIsNeverParsedStillHasTheRequestContent(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);
        $params = ['maxTokens' => 16, 'system' => 'Be brief.', 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];

        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'invalid_request_error', 'message' => 'bad']], status: 400));

        try {
            $client->messages->create(...$params);
            $this->fail('expected an exception');
        } catch (APIStatusException) {
        }
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $response = $client->messages->raw->create($params);
        unset($response);
        // A body that is no Message: the span has no response attributes, and no output content.
        $this->transporter->addResponse(self::json([])->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('[1, 2, 3]')));
        $client->messages->raw->create($params)->parse();

        $spans = $this->spans();
        $this->assertCount(3, $spans);
        foreach ($spans as $span) {
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame([['type' => 'text', 'content' => 'Be brief.']], self::decode($attributes['gen_ai.system_instructions']));
            $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($attributes['gen_ai.input.messages']));
            $this->assertArrayNotHasKey('gen_ai.output.messages', $attributes);
            $this->assertArrayNotHasKey('gen_ai.response.id', $attributes);
        }
    }

    public function testBinaryDownloadEndsAfterTheBody(): void
    {
        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('%PDF-1.7'))
        );

        $contents = $this->client()->beta->files->download('file_1');

        $this->assertSame('%PDF-1.7', $contents);
        $span = $this->onlySpan();
        $this->assertSame('anthropic.files.download', $span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
    }

    public function testResponseCopiedBeforeParsingRecordsTheWholeCall(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE, headers: ['request-id' => 'req_123']));

        $message = $this->client()->messages->raw->create(['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'])
            ->withHeader('x-local', 'yes')
            ->parse()
        ;

        $this->assertSame('msg_1', $message->id);
        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('msg_1', $attributes['gen_ai.response.id']);
        $this->assertSame(5, $attributes['gen_ai.usage.output_tokens']);
        $this->assertSame('req_123', $attributes['anthropic.request.id']);
    }

    public function testProviderRegisteredAfterTheClientIsCreatedStillTraces(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        // No `tracerProvider` option: the client uses whichever provider is registered when a call starts.
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0]);

        $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $this->assertSame([], $this->spans());

        $scope = Configurator::create()->withTracerProvider($this->tracerProvider)->withPropagator(TraceContextPropagator::getInstance())->activate();

        try {
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        } finally {
            $scope->detach();
        }

        $this->assertSame('anthropic.messages.create', $this->onlySpan()->getName());
        $this->assertNotSame('', $this->lastRequest()->getHeaderLine('traceparent'));
    }

    public function testCallWithoutATracerProviderReadsNothingForItsSpanAndStillPropagatesTheSpanAboveIt(): void
    {
        $client = new class(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0]) extends Client {
            public int $mergedHeaders = 0;

            public function mergedHeaders(array $headers, RequestOptions $options): array
            {
                ++$this->mergedHeaders;

                return parent::mergedHeaders($headers, $options);
            }
        };
        $create = function () use ($client): void {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $this->assertSame('msg_1', $client->beta->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', betas: ['beta-a'])->id);
        };

        // No tracer provider is registered: the span would record nothing, so nothing is read for it.
        $create();
        $this->assertSame(0, $client->mergedHeaders);
        $this->assertSame('', $this->lastRequest()->getHeaderLine('traceparent'));

        // The trace context of a span above the call still reaches the request.
        $scope = Span::wrap(SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED))->activate();

        try {
            $create();
        } finally {
            $scope->detach();
        }
        $this->assertSame(0, $client->mergedHeaders);
        $this->assertSame('00-0af7651916cd43dd8448eb211c80319c-b7ad6b7169203331-01', $this->lastRequest()->getHeaderLine('traceparent'));
        $this->assertSame([], $this->spans());

        // With a provider registered, the span starts with the beta names, which come from the merged headers.
        $scope = Configurator::create()->withTracerProvider($this->tracerProvider)->withPropagator(TraceContextPropagator::getInstance())->activate();

        try {
            $create();
        } finally {
            $scope->detach();
        }
        $this->assertSame(1, $client->mergedHeaders);
        $this->assertSame(['beta-a'], $this->onlySpan()->getAttributes()->get('anthropic.beta'));
    }

    /**
     * A sampler, a span processor, a propagator, a tracer provider or a span that throws leaves every call with its own result, or its own exception.
     */
    #[DataProvider('telemetryThatThrows')]
    public function testTelemetryThatThrowsChangesNeitherTheResultNorTheExceptionOfACall(string $where): void
    {
        [$provider, $propagator] = $this->telemetryThatThrowsAt($where);
        $client = $this->client(['tracerProvider' => $provider]);
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];
        $batch = ['id' => 'msgbatch_1', 'type' => 'message_batch', 'processing_status' => 'ended', 'request_counts' => ['processing' => 0, 'succeeded' => 1, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];
        $scope = null === $propagator ? null : Configurator::create()->withPropagator($propagator)->activate();

        try {
            // A method that starts its own call span, and one whose span the client starts.
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $this->assertSame('msg_1', $client->messages->create(...$params)->id);
            $this->transporter->addResponse(self::json($batch));
            $this->assertSame('msgbatch_1', $client->messages->batches->retrieve('msgbatch_1')->id);
            $this->transporter->addResponse(self::json(['input_tokens' => 7]));
            $this->assertSame(7, $client->messages->countTokens(messages: $params['messages'], model: 'claude-test')->inputTokens);
            // A client that signs its requests, which sets the trace context headers aside while it does.
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $signing = new Aws\Client(awsAccessKey: 'AKID', awsSecretAccessKey: 'secret', awsRegion: 'us-east-1', workspaceId: 'default', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0], openTelemetry: ['tracerProvider' => $provider]);
            $this->assertSame('msg_1', $signing->messages->create(...$params)->id);
            $this->assertStringStartsWith('AWS4-HMAC-SHA256 ', $this->lastRequest()->getHeaderLine('Authorization'));

            // A call that fails keeps its own exception.
            foreach ([fn () => $client->messages->create(...$params), fn () => $client->messages->batches->retrieve('msgbatch_1')] as $call) {
                $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'not_found_error', 'message' => 'no such thing']], status: 404));

                try {
                    $call();
                    $this->fail('expected a NotFoundException');
                } catch (NotFoundException) {
                }
            }

            // A raw response that is dropped without being parsed, whose span ends as PHP frees it.
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $response = $client->messages->raw->create($params);
            unset($response);

            // A stream read to its end, one closed part-way, and one dropped part-way.
            $this->transporter->addResponse(self::sse(self::streamEvents()));
            $this->assertCount(6, iterator_to_array($client->messages->createStream(...$params), false));
            foreach (['close', 'drop'] as $ending) {
                $this->transporter->addResponse(self::sse(self::streamEvents()));
                $stream = $client->messages->createStream(...$params);
                foreach ($stream as $event) {
                    break;
                }
                'close' === $ending && $stream->close();
                unset($stream, $event);
                gc_collect_cycles();
            }

            // A stream that fails while it is read keeps the exception of its `error` event.
            $this->transporter->addResponse(self::sse([self::streamEvents()[0], ['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'Overloaded']]]));

            try {
                iterator_to_array($client->messages->createStream(...$params), false);
                $this->fail('expected an APIStatusException');
            } catch (APIStatusException $e) {
                $this->assertStringContainsString('Overloaded', $e->getMessage());
            }
        } finally {
            $scope?->detach();
        }
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function telemetryThatThrows(): iterable
    {
        foreach (['sampler', 'processor on start', 'processor on end', 'propagator', 'tracer provider', 'span'] as $where) {
            yield $where => [$where];
        }
    }

    public function testClientWhoseRequestMethodReturnsAnotherResponseGetsThatResponseBack(): void
    {
        $response = new class(self::json(self::MESSAGE)) implements BaseResponse {
            use ResponseProxy;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function getRequest(): RequestInterface
            {
                return Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', 'https://api.example.test/v1/messages');
            }

            public function getRequestID(): ?string
            {
                return null;
            }

            public function getWorkspaceID(): ?string
            {
                return null;
            }

            public function parse(): mixed
            {
                return null;
            }
        };
        $client = new class($response) extends Client {
            /**
             * @param BaseResponse<mixed> $canned
             */
            public function __construct(private BaseResponse $canned)
            {
                parent::__construct(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', openTelemetry: false);
            }

            public function request(string $method, string|array $path, array $query = [], array $headers = [], mixed $body = null, string|int|array|null $unwrap = null, string|Converter|ConverterSource|null $convert = null, ?string $page = null, ?string $stream = null, RequestOptions|array|null $options = []): BaseResponse
            {
                return $this->canned;
            }
        };
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];

        $this->assertSame($response, $client->messages->raw->create($params));
        $this->assertSame($response, $client->messages->raw->countTokens(['messages' => $params['messages'], 'model' => 'claude-test']));
        $this->assertSame($response, $client->beta->messages->raw->create($params));
        $this->assertSame($response, $client->beta->messages->raw->countTokens(['messages' => $params['messages'], 'model' => 'claude-test']));
    }

    public function testErrorResponseSetsErrorTypeFromEnvelope(): void
    {
        $this->transporter->addResponse(self::json(
            ['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']],
            status: 429,
            headers: ['request-id' => 'req_429'],
        ));

        try {
            $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $this->fail('expected a RateLimitException');
        } catch (RateLimitException) {
        }

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('rate_limit_error', $attributes['error.type']);
        $this->assertSame(429, $attributes['http.response.status_code']);
        $this->assertSame('req_429', $attributes['anthropic.request.id']);
        $this->assertArrayNotHasKey('gen_ai.response.id', $attributes);
        $this->assertArrayNotHasKey('anthropic.message.stop_reason', $attributes);
    }

    public function testRequestThatCannotBeBuiltEndsTheSpanItsMethodStarted(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];
        // A header name that PSR-7 refuses: the request fails before anything is sent.
        $options = ['extraHeaders' => ["bad header\n" => 'x']];
        $before = Context::getCurrent();
        $calls = [
            'anthropic.messages.create' => static fn () => $client->messages->create(...$params, requestOptions: $options),
            'anthropic.messages.create ' => static fn () => $client->beta->messages->createStream(...$params, requestOptions: $options),
            'anthropic.messages.count_tokens' => static fn () => $client->messages->countTokens(messages: $params['messages'], model: 'claude-test', requestOptions: $options),
            'anthropic.models.retrieve' => static fn () => $client->models->retrieve('claude-test', requestOptions: $options),
        ];

        foreach ($calls as $call) {
            try {
                $call();
                $this->fail('expected the request to be refused');
            } catch (\InvalidArgumentException) {
            }
            $this->assertSame($before, Context::getCurrent());
        }
        gc_collect_cycles();

        $this->assertSame([], $this->transporter->getRequests());
        // Every span that was started has ended: the ones the Messages methods start themselves, and none is left open.
        $spans = $this->spans();
        $this->assertSame(['anthropic.messages.create', 'anthropic.messages.create', 'anthropic.messages.count_tokens'], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $spans));
        foreach ($spans as $span) {
            $this->assertTrue($span->hasEnded());
            $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame('client_error', $attributes['error.type']);
            $this->assertSame('anthropic', $attributes['gen_ai.provider.name']);
            $this->assertSame('claude-test', $attributes['gen_ai.request.model']);
            $this->assertArrayNotHasKey('http.response.status_code', $attributes);
            $this->assertSame('api.example.test', $attributes['server.address']);
            // The span started with the method and the route. No request was built, so it has no URL.
            $this->assertSame('POST', $attributes['http.request.method']);
            $this->assertSame('anthropic.messages.count_tokens' === $span->getName() ? '/v1/messages/count_tokens' : '/v1/messages', $attributes['http.route']);
            $this->assertSame([], array_filter(array_keys($attributes), static fn (int|string $name): bool => str_starts_with((string) $name, 'url.')));
            $this->assertArrayNotHasKey('http.request.resend_count', $attributes);
        }
        $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($spans[0]->getAttributes()->get('gen_ai.input.messages')));
    }

    public function testFailedCallRecordsNothingOfTheErrorMessage(): void
    {
        $secret = 'not-a-real-secret-value-123';
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];
        $client = $this->client();

        // A header value that PSR-7 refuses, and may quote in its error: the request fails before anything is sent.
        $refused = static fn () => $client->messages->create(...$params, requestOptions: ['extraHeaders' => ['x-api-key' => "{$secret}\nx-injected: 1"]]);

        try {
            $refused();
            $this->fail('expected the request to be refused');
        } catch (\InvalidArgumentException) {
        }
        // An HTTP client's error that quotes the URL it could not reach, and an error response whose message quotes the request.
        $this->transporter->addException(new NetworkException("could not connect to https://api.example.test:8443/v1/messages?token={$secret}", Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', '/v1/messages')));

        try {
            $client->messages->create(...$params);
            $this->fail('expected an APIConnectionException');
        } catch (APIConnectionException) {
        }
        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'invalid_request_error', 'message' => "bad value {$secret}"]], status: 400));

        try {
            $client->messages->create(...$params);
            $this->fail('expected an APIStatusException');
        } catch (APIStatusException) {
        }

        $spans = $this->spans();
        $this->assertSame(['client_error', 'connection_error', 'invalid_request_error'], array_map(static fn (ImmutableSpan $span): mixed => $span->getAttributes()->get('error.type'), $spans));
        foreach ($spans as $span) {
            // The span has the error status and the kind of error, and nothing the error says.
            $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
            $this->assertSame('', $span->getStatus()->getDescription());
            $this->assertSame([], $span->getEvents());
            $this->assertStringNotContainsString($secret, json_encode($span->getAttributes()->toArray(), JSON_THROW_ON_ERROR));
            $this->assertStringNotContainsString($secret, $span->getName());
        }
    }

    public function testConnectionErrorSetsConnectionErrorType(): void
    {
        $this->transporter->addException(new NetworkException('unreachable', Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', '/v1/messages')));

        try {
            $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $this->fail('expected an APIConnectionException');
        } catch (APIConnectionException) {
        }

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $this->assertSame('connection_error', $span->getAttributes()->get('error.type'));
        $this->assertNull($span->getAttributes()->get('http.response.status_code'));
        $this->assertSame('api.example.test', $span->getAttributes()->get('server.address'));
        $this->assertSame(8443, $span->getAttributes()->get('server.port'));
    }

    public function testTraceContextHeadersCarryTheCallSpanAndTraceState(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $parent = Span::wrap(SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED, new TraceState('vendor=value')));
        $scope = Context::getCurrent()->withContextValue($parent)->activate();

        try {
            $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        } finally {
            $scope->detach();
        }

        $span = $this->onlySpan();
        $this->assertSame('0af7651916cd43dd8448eb211c80319c', $span->getTraceId());
        $this->assertSame('b7ad6b7169203331', $span->getParentSpanId());
        $request = $this->lastRequest();
        $this->assertSame("00-0af7651916cd43dd8448eb211c80319c-{$span->getSpanId()}-01", $request->getHeaderLine('traceparent'));
        $this->assertSame('vendor=value', $request->getHeaderLine('tracestate'));
    }

    public function testRedirectOffTheOriginCarriesNoTraceContext(): void
    {
        [$first, $redirected] = $this->redirectedRequests('https://elsewhere.example.test/v1/messages');

        $this->assertNotSame('', $first->getHeaderLine('traceparent'));
        $this->assertSame('vendor=value', $first->getHeaderLine('tracestate'));
        $this->assertSame('user_id=12345', $first->getHeaderLine('baggage'));
        foreach (['traceparent', 'tracestate', 'baggage'] as $name) {
            $this->assertFalse($redirected->hasHeader($name), $name);
        }
        // No attempt writes the server of its own request over the one the span started with.
        $this->assertSame('api.example.test', $this->onlySpan()->getAttributes()->get('server.address'));
    }

    public function testRedirectOffTheOriginCarriesNoTraceContextEvenWhenThePropagatorCannotListItsFields(): void
    {
        $writes = new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willThrowException(new \RuntimeException('telemetry failed'));
        $propagator->method('inject')->willReturnCallback(static function (mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null) use ($writes): void {
            $writes->inject($carrier, $setter, $context);
        });

        [$first, $redirected] = $this->redirectedRequests('https://elsewhere.example.test/v1/messages', $propagator);

        $this->assertNotSame('', $first->getHeaderLine('traceparent'));
        $this->assertSame('user_id=12345', $first->getHeaderLine('baggage'));
        foreach (['traceparent', 'tracestate', 'baggage'] as $name) {
            $this->assertFalse($redirected->hasHeader($name), $name);
        }
    }

    public function testRedirectOffTheOriginCarriesNoTraceContextEvenWhenThePropagatorThrowsOnThatAttempt(): void
    {
        $writes = new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $failure = new \RuntimeException('telemetry failed');
        // The propagator writes the headers of the first attempt, and can do nothing from then on.
        $injected = 0;
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willThrowException($failure);
        $propagator->method('inject')->willReturnCallback(static function (mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null) use ($writes, $failure, &$injected): void {
            if (++$injected > 1) {
                throw $failure;
            }
            $writes->inject($carrier, $setter, $context);
        });

        [$first, $redirected] = $this->redirectedRequests('https://elsewhere.example.test/v1/messages', $propagator);

        $this->assertSame(2, $injected);
        $this->assertNotSame('', $first->getHeaderLine('traceparent'));
        $this->assertSame('vendor=value', $first->getHeaderLine('tracestate'));
        $this->assertSame('user_id=12345', $first->getHeaderLine('baggage'));
        foreach (['traceparent', 'tracestate', 'baggage'] as $name) {
            $this->assertFalse($redirected->hasHeader($name), $name);
        }
    }

    public function testRedirectOffTheOriginOfAClientWithoutPropagationNeverAsksThePropagatorToInject(): void
    {
        $writes = new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $injected = 0;
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willReturn($writes->fields());
        $propagator->method('inject')->willReturnCallback(static function (mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null) use ($writes, &$injected): void {
            ++$injected;
            $writes->inject($carrier, $setter, $context);
        });

        foreach ([true, false] as $propagation) {
            $before = $injected;

            [$first, $redirected] = $this->redirectedRequests('https://elsewhere.example.test/v1/messages', $propagator, $propagation);

            foreach (['traceparent', 'tracestate', 'baggage'] as $name) {
                $this->assertSame($propagation, $first->hasHeader($name), $name);
                $this->assertFalse($redirected->hasHeader($name), $name);
            }
            if ($propagation) {
                $this->assertGreaterThan($before, $injected);
            } else {
                $this->assertSame($before, $injected);
            }
        }

        $this->assertCount(2, $this->spans());
    }

    public function testRedirectOnTheOriginKeepsTheTraceContext(): void
    {
        [$first, $redirected] = $this->redirectedRequests('/v2/messages');

        foreach (['traceparent', 'tracestate', 'baggage'] as $name) {
            $this->assertNotSame('', $first->getHeaderLine($name), $name);
            $this->assertSame($first->getHeaderLine($name), $redirected->getHeaderLine($name), $name);
        }
    }

    public function testAwsSignaturesLeaveOutTheTraceContextHeaders(): void
    {
        $option = ['tracerProvider' => $this->tracerProvider];
        $requestOptions = ['transporter' => $this->transporter, 'maxRetries' => 0];
        $clients = [
            'bedrock' => Bedrock\Client::withCredentials('AKID', 'secret', region: 'us-east-1', requestOptions: $requestOptions, openTelemetry: $option),
            'mantle' => new MantleClient(awsAccessKey: 'AKID', awsSecretAccessKey: 'secret', awsRegion: 'us-east-1', requestOptions: $requestOptions, openTelemetry: $option),
            'aws' => new Aws\Client(awsAccessKey: 'AKID', awsSecretAccessKey: 'secret', awsRegion: 'us-east-1', workspaceId: 'default', requestOptions: $requestOptions, openTelemetry: $option),
        ];
        $parent = Span::wrap(SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED, new TraceState('vendor=value')));
        $parentOtelContext = Context::getCurrent()->withContextValue($parent)->withContextValue(Baggage::getBuilder()->set('user_id', '12345')->build());
        $propagator = new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);

        foreach ($clients as $name => $client) {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $scope = Configurator::create()->withPropagator($propagator)->storeInContext($parentOtelContext)->activate();

            try {
                $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            } finally {
                $scope->detach();
            }

            $request = $this->lastRequest();
            // An HTTP instrumentation may replace these headers with its own span's after the SDK signs, so the signature must not cover them.
            $this->assertSame(1, preg_match('/^AWS4-HMAC-SHA256 .*SignedHeaders=([^,]+),/', $request->getHeaderLine('Authorization'), $matches), $name);
            $signed = explode(';', $matches[1]);
            $this->assertContains('host', $signed, $name);
            $this->assertContains('x-amz-date', $signed, $name);
            foreach (['traceparent' => '/^00-0af7651916cd43dd8448eb211c80319c-[0-9a-f]{16}-01$/', 'tracestate' => '/^vendor=value$/', 'baggage' => '/^user_id=12345$/'] as $header => $pattern) {
                $this->assertMatchesRegularExpression($pattern, $request->getHeaderLine($header), "{$name}: {$header}");
                $this->assertNotContains($header, $signed, "{$name}: {$header}");
            }
        }
    }

    public function testCallSpanIsCurrentWhileTheSdkSendsTheRequestAndNotOnceTheMethodReturns(): void
    {
        // An instrumented HTTP client, as the application may have one: it starts a span for each request it sends.
        $http = new class($this->transporter, $this->tracerProvider->getTracer('http')) implements ClientInterface {
            public function __construct(private ClientInterface $inner, private TracerInterface $tracer) {}

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $span = $this->tracer->spanBuilder('HTTP POST')->startSpan();

                try {
                    return $this->inner->sendRequest($request);
                } finally {
                    $span->end();
                }
            }
        };
        $inMiddleware = [];
        $middleware = static function (RequestInterface $request, \Closure $next) use (&$inMiddleware): ResponseInterface {
            $inMiddleware[] = Span::getCurrent()->getContext()->getSpanId();

            $response = $next($request);
            self::assertInstanceOf(ResponseInterface::class, $response);

            return $response;
        };
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test:8443', requestOptions: ['transporter' => $http, 'maxRetries' => 0, 'middleware' => [$middleware]], openTelemetry: ['tracerProvider' => $this->tracerProvider]);
        $before = Context::getCurrent();

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $this->assertSame($before, Context::getCurrent());

        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $stream = $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $this->assertSame($before, Context::getCurrent());
        foreach ($stream as $event) {
            // The span is open while the application reads the stream, but it is not current.
            $this->assertSame($before, Context::getCurrent());
        }
        $this->assertSame($before, Context::getCurrent());

        [$firstHttp, $create, $secondHttp, $createStream] = $this->spans();
        $this->assertSame(['HTTP POST', 'anthropic.messages.create', 'HTTP POST', 'anthropic.messages.create'], [$firstHttp->getName(), $create->getName(), $secondHttp->getName(), $createStream->getName()]);
        $this->assertSame($create->getSpanId(), $firstHttp->getParentSpanId());
        $this->assertSame($create->getTraceId(), $firstHttp->getTraceId());
        $this->assertSame($createStream->getSpanId(), $secondHttp->getParentSpanId());
        $this->assertSame([$create->getSpanId(), $createStream->getSpanId()], $inMiddleware);
    }

    public function testEnvironmentVariableDisablesSpansAndHeaders(): void
    {
        putenv('ANTHROPIC_OPEN_TELEMETRY=FALSE');
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));

        $this->clientWithoutTheOption()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $disabled = $this->spans();
        $this->assertSame([], $disabled);
        $this->assertSame('', $this->lastRequest()->getHeaderLine('traceparent'));

        // A client that is given the option does not read the variable.
        $this->client(['tracerProvider' => $this->tracerProvider])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $enabled = $this->spans();
        $this->assertCount(1, $enabled);

        // An empty option is an option. Its spans go to the registered tracer provider.
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION=false');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=content');
        $this->client([])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $afterEmpty = $this->spans();
        $this->assertCount(2, $afterEmpty);
        $this->assertNotSame('', $this->lastRequest()->getHeaderLine('traceparent'));
        $this->assertNull($afterEmpty[1]->getAttributes()->get('gen_ai.input.messages'));

        putenv('ANTHROPIC_OPEN_TELEMETRY');
        $this->client(false)->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $afterFalse = $this->spans();
        $this->assertCount(2, $afterFalse);
    }

    /**
     * @param array<string, mixed>|false|null $option null for a client that is given no option
     */
    #[DataProvider('propagationSettings')]
    public function testPropagationSettingSendsTheRequestsWithOrWithoutTheTraceContext(array|false|null $option, ?string $variable, bool $headers, bool $spans): void
    {
        if (null !== $variable) {
            putenv("ANTHROPIC_OPEN_TELEMETRY_PROPAGATION={$variable}");
        }
        // @phpstan-ignore-next-line argument.type
        $client = null === $option ? $this->clientWithoutTheOption() : $this->client(false === $option ? false : ['tracerProvider' => $this->tracerProvider, ...$option]);
        // A method that starts its own call span, and one whose span the client starts.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(['id' => 'claude-test', 'type' => 'model', 'display_name' => 'Test', 'created_at' => '2026-01-01T00:00:00Z']));

        $this->underAParentSpanWithBaggage(static function () use ($client): void {
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $client->models->retrieve('claude-test');
        });

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        foreach ($requests as $request) {
            $path = $request->getUri()->getPath();
            foreach (['traceparent' => '/^00-0af7651916cd43dd8448eb211c80319c-[0-9a-f]{16}-01$/', 'tracestate' => '/^vendor=value$/', 'baggage' => '/^user_id=12345$/'] as $header => $pattern) {
                if ($headers) {
                    $this->assertMatchesRegularExpression($pattern, $request->getHeaderLine($header), "{$path}: {$header}");
                } else {
                    $this->assertFalse($request->hasHeader($header), "{$path}: {$header}");
                }
            }
        }

        // The spans are the same with or without the headers.
        $this->assertSame($spans ? ['anthropic.messages.create', 'anthropic.models.retrieve'] : [], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $this->spans()));
        foreach ($this->spans() as $span) {
            $this->assertTrue($span->hasEnded());
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
            $this->assertSame('0af7651916cd43dd8448eb211c80319c', $span->getTraceId());
            $this->assertSame('b7ad6b7169203331', $span->getParentSpanId());
        }
    }

    /**
     * @return iterable<string, array{array<string, mixed>|false|null, string|null, bool, bool}>
     */
    public static function propagationSettings(): iterable
    {
        yield 'on by default' => [[], null, true, true];

        yield '`true`' => [['propagation' => true], null, true, true];

        yield '`false`' => [['propagation' => false], null, false, true];

        yield 'on by default without the option' => [null, null, true, true];

        yield 'the variable set to `false`' => [null, 'false', false, true];

        yield 'the variable in another case' => [null, 'FALSE', false, true];

        yield 'another value of the variable is ignored' => [null, '0', true, true];

        yield 'a client that is given the option does not read the variable' => [[], 'false', true, true];

        yield 'nor does one that is given only `traces`' => [['traces' => ['enabled' => true]], 'false', true, true];

        yield '`true` in code wins over the variable' => [['propagation' => true], 'false', true, true];

        yield '`false` in code wins over the variable' => [['propagation' => false], 'true', false, true];

        yield 'null is as if it were left out' => [['propagation' => null], 'false', true, true];

        yield 'spans that are not enabled have no trace context to send' => [['traces' => false, 'propagation' => true], null, false, false];

        yield '`false` for the whole option' => [false, 'true', false, false];
    }

    public function testClientWithoutPropagationNeverAsksThePropagator(): void
    {
        $writes = new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $injected = 0;
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willReturn($writes->fields());
        $propagator->method('inject')->willReturnCallback(static function (mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null) use ($writes, &$injected): void {
            ++$injected;
            $writes->inject($carrier, $setter, $context);
        });
        $requestOptions = ['transporter' => $this->transporter, 'maxRetries' => 1];
        $sampledOut = new TracerProvider(new SimpleSpanProcessor($this->exporter), new AlwaysOffSampler);
        // A span that records, one that a sampler drops, and one of an application that has registered no tracer provider.
        $providers = ['recording' => $this->tracerProvider, 'sampled out' => $sampledOut, 'no tracer provider' => null];

        foreach ([false, true] as $propagation) {
            foreach ($providers as $name => $provider) {
                $before = $injected;
                $sent = count($this->transporter->getRequests());
                // The first attempt fails, so the call sends two.
                $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'Overloaded']], 529, ['retry-after-ms' => '1']));
                $this->transporter->addResponse(self::json(self::MESSAGE));
                $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: $requestOptions, openTelemetry: [...(null === $provider ? [] : ['tracerProvider' => $provider]), 'propagation' => $propagation]);

                $this->underAParentSpanWithBaggage(static function () use ($client): void {
                    $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
                }, $propagator);

                $attempts = array_slice($this->transporter->getRequests(), $sent);
                $this->assertCount(2, $attempts, $name);
                foreach ($attempts as $attempt) {
                    foreach (['traceparent', 'tracestate', 'baggage'] as $header) {
                        $this->assertSame($propagation, $attempt->hasHeader($header), "{$name}: {$header}");
                    }
                }
                if ($propagation) {
                    $this->assertGreaterThan($before, $injected, $name);
                } else {
                    $this->assertSame($before, $injected, $name);
                }
            }
        }

        // Only the spans that record are exported, with or without the headers.
        $this->assertCount(2, $this->spans());
    }

    public function testCallSpanThatASamplerDropsIsStillCurrentWhileAClientWithoutPropagationSendsItsAttempts(): void
    {
        $injected = 0;
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willReturn(TraceContextPropagator::getInstance()->fields());
        $propagator->method('inject')->willReturnCallback(static function (mixed &$carrier, ?PropagationSetterInterface $setter = null, ?ContextInterface $context = null) use (&$injected): void {
            ++$injected;
            TraceContextPropagator::getInstance()->inject($carrier, $setter, $context);
        });
        // An HTTP client that notes the span that is current at each request it sends, as an instrumented one reads it for the parent of its own span.
        $http = new class($this->transporter) implements ClientInterface {
            /** @var list<SpanContextInterface> */
            public array $current = [];

            public function __construct(private ClientInterface $inner) {}

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->current[] = Span::getCurrent()->getContext();

                return $this->inner->sendRequest($request);
            }
        };
        $sampledOut = new TracerProvider(new SimpleSpanProcessor($this->exporter), new AlwaysOffSampler);
        $parent = SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED);
        $scope = Configurator::create()->withPropagator($propagator)->activate();

        try {
            // A span that a sampler drops has a valid context; the span of an application that has registered no tracer provider has one only under a span that does.
            foreach ([[$sampledOut, null, true], [$sampledOut, $parent, true], [null, null, false], [null, $parent, true]] as $at => [$provider, $above, $valid]) {
                $seen = count($http->current);
                $sent = count($this->transporter->getRequests());
                // The first attempt fails, so the call sends two.
                $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'api_error', 'message' => 'Internal server error']], 500, ['retry-after-ms' => '1']));
                $this->transporter->addResponse(self::json(self::MESSAGE));
                $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $http, 'maxRetries' => 1], openTelemetry: [...(null === $provider ? [] : ['tracerProvider' => $provider]), 'propagation' => false]);
                $before = Context::getCurrent();
                $aboveScope = null === $above ? null : Span::wrap($above)->activate();

                try {
                    $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
                } finally {
                    $aboveScope?->detach();
                }

                $this->assertSame($before, Context::getCurrent(), "case {$at}");
                $attempts = array_slice($this->transporter->getRequests(), $sent);
                $this->assertCount(2, $attempts, "case {$at}");
                foreach ($attempts as $attempt) {
                    $this->assertFalse($attempt->hasHeader('traceparent'), "case {$at}");
                }
                $current = array_slice($http->current, $seen);
                $this->assertCount(2, $current, "case {$at}");
                [$first, $second] = $current;
                $this->assertSame($valid, $first->isValid(), "case {$at}");
                $this->assertSame($valid, $second->isValid(), "case {$at}");
                $this->assertSame($first->getSpanId(), $second->getSpanId(), "case {$at}");
                if (null !== $provider) {
                    // The call span, not the span above it, with the sampler's decision and in the trace of the span above it.
                    $this->assertFalse($first->isSampled(), "case {$at}");
                    $this->assertFalse($second->isSampled(), "case {$at}");
                    $this->assertNotSame($parent->getSpanId(), $first->getSpanId(), "case {$at}");
                }
                if (null !== $above) {
                    $this->assertSame($parent->getTraceId(), $first->getTraceId(), "case {$at}");
                }
            }
        } finally {
            $scope->detach();
        }

        $this->assertSame(0, $injected);
        $this->assertSame([], $this->spans());
    }

    public function testPropagationIsReadOnceWhenTheClientIsBuiltAndIsNoRequestOption(): void
    {
        $create = function (Client $client): RequestInterface {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

            return $this->lastRequest();
        };

        $plain = $this->clientWithoutTheOption();
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION=false');
        $quiet = $this->clientWithoutTheOption();

        $this->assertTrue($create($plain)->hasHeader('traceparent'));
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION');
        $this->assertFalse($create($quiet)->hasHeader('traceparent'));
        $this->assertCount(2, $this->spans());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown key 'propagation' in the `openTelemetry` request option: the keys it takes are 'conversationId'");
        // @phpstan-ignore-next-line argument.type
        $plain->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', requestOptions: ['openTelemetry' => ['propagation' => false]]);
    }

    /**
     * @param array<mixed> $option
     * @param list<string> $keys
     */
    #[DataProvider('clientOptionsWithAKeyTheyDoNotTake')]
    public function testClientOptionKeyThatTheOptionDoesNotTakeIsRefusedAndNotIgnored(array $option, string $unknown, array $keys): void
    {
        try {
            // @phpstan-ignore-next-line argument.type
            new Client(apiKey: 'test-api-key', requestOptions: ['transporter' => $this->transporter], openTelemetry: $option);
            $this->fail('expected the option to be refused');
        } catch (\InvalidArgumentException $e) {
            // The message names the key, and the keys to choose from.
            $this->assertStringContainsString("Unknown key {$unknown} in ", $e->getMessage());
            $this->assertStringContainsString('`openTelemetry` client option', $e->getMessage());
            foreach ($keys as $key) {
                $this->assertStringContainsString("'{$key}'", $e->getMessage());
            }
        }

        // A platform client takes the same option.
        try {
            // @phpstan-ignore-next-line argument.type
            Bedrock\Client::withApiKey('key', region: 'us-east-1', requestOptions: ['transporter' => $this->transporter], openTelemetry: $option);
            $this->fail('expected the option to be refused');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("Unknown key {$unknown} in ", $e->getMessage());
        }
    }

    /**
     * @return iterable<string, array{array<mixed>, string, list<string>}>
     */
    public static function clientOptionsWithAKeyTheyDoNotTake(): iterable
    {
        $keys = ['tracerProvider', 'propagation', 'traces'];
        $tracesKeys = ['enabled', 'contentMode', 'maxContentBytes'];

        yield 'a key in the wrong case' => [['tracerprovider' => null], "'tracerprovider'", $keys];

        yield 'a misspelled key beside a valid one' => [['traces' => true, 'trace' => true], "'trace'", $keys];

        yield 'a key that holds an array' => [['signals' => ['traces' => false]], "'signals'", $keys];

        yield 'a key of `traces` beside it' => [['contentMode' => 'content'], "'contentMode'", $keys];

        yield 'a key of the request option' => [['conversationId' => 'conv_1'], "'conversationId'", $keys];

        yield 'a value without a key' => [['content'], '0', $keys];

        yield 'a misspelled key of `traces`' => [['traces' => ['contentmode' => 'content']], "'contentmode'", $tracesKeys];

        yield 'a key of `traces` that the option takes beside it' => [['traces' => ['tracerProvider' => null]], "'tracerProvider'", $tracesKeys];

        yield '`propagation` under `traces`' => [['traces' => ['propagation' => false]], "'propagation'", $tracesKeys];
    }

    public function testRequestOptionKeyThatTheOptionDoesNotTakeIsRefusedAndNotIgnored(): void
    {
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $uses = [
            // @phpstan-ignore-next-line argument.type
            'an array of request options' => fn (): mixed => $this->client()->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test', requestOptions: ['openTelemetry' => ['conversationID' => 'conv_1']]),
            // @phpstan-ignore-next-line argument.type
            'the request options of a raw method' => fn (): mixed => $this->client()->models->raw->retrieve('claude-test', [], ['openTelemetry' => ['conversationID' => 'conv_1']]),
            // @phpstan-ignore-next-line argument.type
            'RequestOptions::with()' => static fn (): mixed => RequestOptions::with(openTelemetry: ['conversationID' => 'conv_1']),
            // @phpstan-ignore-next-line argument.type
            'withOpenTelemetry()' => static fn (): mixed => (new RequestOptions)->withOpenTelemetry(['conversationID' => 'conv_1']),
            // @phpstan-ignore-next-line argument.type
            'the request options of a client' => fn (): mixed => new Client(apiKey: 'test-api-key', requestOptions: ['transporter' => $this->transporter, 'openTelemetry' => ['conversationID' => 'conv_1']]),
        ];

        foreach ($uses as $name => $use) {
            try {
                $use();
                $this->fail("{$name}: expected the option to be refused");
            } catch (\InvalidArgumentException $e) {
                $this->assertSame("Unknown key 'conversationID' in the `openTelemetry` request option: the keys it takes are 'conversationId'", $e->getMessage(), $name);
            }
        }

        // The option is refused before a request is sent or a span started.
        $this->assertSame([], $this->transporter->getRequests());
        $this->assertSame([], $this->spans());

        // The key as the option spells it is taken, on its own or with no key at all.
        $this->assertSame(['conversationId' => 'conv_1'], RequestOptions::with(openTelemetry: ['conversationId' => 'conv_1'])->openTelemetry);
        $this->assertSame([], (new RequestOptions)->withOpenTelemetry([])->openTelemetry);
    }

    public function testRequestOptionConversationIdThatIsNoStringIsRefusedAndNotIgnored(): void
    {
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $uses = [
            // @phpstan-ignore-next-line argument.type
            'an array of request options' => fn (): mixed => $this->client()->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test', requestOptions: ['openTelemetry' => ['conversationId' => 5]]),
            // @phpstan-ignore-next-line argument.type
            'RequestOptions::with()' => static fn (): mixed => RequestOptions::with(openTelemetry: ['conversationId' => 5]),
            // @phpstan-ignore-next-line argument.type
            'withOpenTelemetry()' => static fn (): mixed => (new RequestOptions)->withOpenTelemetry(['conversationId' => 5]),
            // @phpstan-ignore-next-line argument.type
            'the request options of a client' => fn (): mixed => new Client(apiKey: 'test-api-key', requestOptions: ['transporter' => $this->transporter, 'openTelemetry' => ['conversationId' => 5]]),
        ];

        foreach ($uses as $name => $use) {
            try {
                $use();
                $this->fail("{$name}: expected the option to be refused");
            } catch (\InvalidArgumentException $e) {
                $this->assertSame("['conversationId'] of the `openTelemetry` request option must be a string, got 5", $e->getMessage(), $name);
            }
        }
        $this->assertSame([], $this->transporter->getRequests());
        $this->assertSame([], $this->spans());

        // Null says nothing, as a missing key does.
        $this->assertSame(['conversationId' => null], RequestOptions::with(openTelemetry: ['conversationId' => null])->openTelemetry);
    }

    public function testEnvironmentVariablesAreReadOnceWhenTheClientIsBuilt(): void
    {
        $create = function (Client $client): void {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        };

        // A client built with neither variable set emits spans without content, whatever the variables say later.
        $plain = $this->clientWithoutTheOption();
        putenv('ANTHROPIC_OPEN_TELEMETRY=false');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=content');
        $create($plain);
        $this->assertNull($this->onlySpan()->getAttributes()->get('gen_ai.input.messages'));

        // A client built while `ANTHROPIC_OPEN_TELEMETRY` is `false` stays without spans once the variable is gone.
        $quiet = $this->clientWithoutTheOption();
        putenv('ANTHROPIC_OPEN_TELEMETRY');
        $create($quiet);
        $this->assertCount(1, $this->spans());

        // A client built while `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` is `content` keeps recording content once the variable is gone.
        $verbose = $this->clientWithoutTheOption();
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE');
        $create($verbose);
        $this->assertCount(2, $this->spans());
        $this->assertNotNull($this->spans()[1]->getAttributes()->get('gen_ai.input.messages'));

        // The client built first still records none, and a client built now reads the variables as they are now.
        $create($plain);
        $create($this->clientWithoutTheOption());
        $this->assertCount(4, $this->spans());
        $this->assertNull($this->spans()[2]->getAttributes()->get('gen_ai.input.messages'));
        $this->assertNull($this->spans()[3]->getAttributes()->get('gen_ai.input.messages'));
    }

    public function testCallSpanStartsWithEverythingKnownOfItsCall(): void
    {
        // A span processor sees a span when it starts, with the attributes that a sampler gets.
        $started = new class() implements SpanProcessorInterface {
            /** @var list<array{string, array<mixed>}> */
            public array $spans = [];

            public function onStart(ReadWriteSpanInterface $span, ContextInterface $parentContext): void
            {
                $attributes = $span->toSpanData()->getAttributes()->toArray();
                ksort($attributes);
                $this->spans[] = [$span->getName(), $attributes];
            }

            public function onEnd(ReadableSpanInterface $span): void {}

            public function forceFlush(?CancellationInterface $cancellation = null): bool
            {
                return true;
            }

            public function shutdown(?CancellationInterface $cancellation = null): bool
            {
                return true;
            }
        };
        $client = $this->client(['tracerProvider' => new TracerProvider($started)]);
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $conversation = ['openTelemetry' => ['conversationId' => 'conv_1']];
        $batch = ['id' => 'msgbatch_1', 'type' => 'message_batch', 'processing_status' => 'ended', 'request_counts' => ['processing' => 0, 'succeeded' => 1, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->beta->messages->create(
            maxTokens: 16,
            messages: $messages,
            model: 'claude-test',
            temperature: 0.5,
            topP: 0.9,
            topK: 5,
            serviceTier: 'auto',
            thinking: ['type' => 'enabled', 'budgetTokens' => 1024],
            outputConfig: ['effort' => 'low', 'format' => ['type' => 'json_schema', 'schema' => ['type' => 'object']]],
            betas: ['beta-a'],
            // The client merges the header of the `betas` parameter with the one among the extra headers.
            requestOptions: [...$conversation, 'extraHeaders' => ['anthropic-beta' => 'beta-b, beta-a']],
        );
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        foreach ($client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test', requestOptions: [...$conversation, 'extraHeaders' => ['anthropic-beta' => 'beta-b']]) as $event);
        // A raw method sends its parameters as they are given: an integer temperature or `top_p` is a double on the span.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->raw->create(['maxTokens' => 16, 'messages' => $messages, 'model' => 'claude-test', 'temperature' => 0, 'topP' => 1], $conversation);
        $this->transporter->addResponse(self::json(['input_tokens' => 12]));
        $client->messages->countTokens(messages: $messages, model: 'claude-test', requestOptions: $conversation);
        // A later page of a list is a call with the options of the first.
        $this->transporter->addResponse(self::json(['data' => [$batch], 'has_more' => true, 'first_id' => 'msgbatch_1', 'last_id' => 'msgbatch_1']));
        $this->transporter->addResponse(self::json(['data' => [[...$batch, 'id' => 'msgbatch_2']], 'has_more' => false, 'first_id' => 'msgbatch_2', 'last_id' => 'msgbatch_2']));
        $client->messages->batches->list(limit: 1, requestOptions: $conversation)->getNextPage();
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->beta->messages->toolRunner(maxTokens: 16, messages: $messages, model: 'claude-test', tools: [], extraParams: ['outputConfig' => ['format' => ['type' => 'json_schema', 'schema' => ['type' => 'object']]], 'requestOptions' => $conversation])->runUntilDone();
        $this->transporter->addResponse(self::json(self::SESSION));
        $client->beta->sessions->create(agent: 'agent_1', environmentID: 'env_1', requestOptions: $conversation);
        $this->transporter->addResponse(self::json($batch));
        $client->messages->batches->create(requests: [['customID' => 'one', 'params' => ['maxTokens' => 16, 'messages' => $messages, 'model' => 'claude-test']], ['customID' => 'two', 'params' => ['maxTokens' => 16, 'messages' => $messages, 'model' => 'claude-test']]], requestOptions: $conversation);
        $this->transporter->addResponse(self::json(['data' => [], 'next_page' => null]));
        $client->beta->sessions->threads->events->list('sthr_1', sessionID: 'sesn_1', requestOptions: $conversation);
        // A call to a Session thread that names no conversation is in the conversation of the thread.
        $this->transporter->addResponse(self::json(['data' => [], 'next_page' => null]));
        $client->beta->sessions->threads->events->list('sthr_1', sessionID: 'sesn_1');

        $everySpan = ['gen_ai.conversation.id' => 'conv_1', 'gen_ai.provider.name' => 'anthropic', 'server.address' => 'api.example.test', 'server.port' => 8443];
        // A sampler sees the method and the route. The URL is that of the first request, which the span gets later.
        $post = ['http.request.method' => 'POST', 'http.route' => '/v1/messages'];
        $listBatches = ['http.request.method' => 'GET', 'http.route' => '/v1/messages/batches'];
        $expected = [
            ['anthropic.messages.create', [
                'anthropic.beta' => ['beta-a', 'beta-b'],
                'anthropic.request.service_tier' => 'auto',
                'anthropic.thinking.budget_tokens' => 1024,
                'anthropic.thinking.type' => 'enabled',
                ...$everySpan,
                ...$post,
                'gen_ai.operation.name' => 'chat',
                'gen_ai.output.type' => 'json',
                'gen_ai.request.max_tokens' => 16,
                'gen_ai.request.model' => 'claude-test',
                'gen_ai.request.reasoning.level' => 'low',
                'gen_ai.request.temperature' => 0.5,
                'gen_ai.request.top_k' => 5,
                'gen_ai.request.top_p' => 0.9,
            ]],
            ['anthropic.messages.create', ['anthropic.beta' => ['beta-b'], ...$everySpan, ...$post, 'gen_ai.operation.name' => 'chat', 'gen_ai.request.max_tokens' => 16, 'gen_ai.request.model' => 'claude-test', 'gen_ai.request.stream' => true]],
            ['anthropic.messages.create', [...$everySpan, ...$post, 'gen_ai.operation.name' => 'chat', 'gen_ai.request.max_tokens' => 16, 'gen_ai.request.model' => 'claude-test', 'gen_ai.request.temperature' => 0.0, 'gen_ai.request.top_p' => 1.0]],
            ['anthropic.messages.count_tokens', [...$everySpan, 'http.request.method' => 'POST', 'http.route' => '/v1/messages/count_tokens', 'gen_ai.request.model' => 'claude-test']],
            ['anthropic.messages.batches.list', [...$everySpan, ...$listBatches]],
            ['anthropic.messages.batches.list', [...$everySpan, ...$listBatches]],
            // The tool runner sends no request of its own, so its span names no server, method or route.
            ['anthropic.messages.tool_runner', ['gen_ai.conversation.id' => 'conv_1', 'gen_ai.provider.name' => 'anthropic', 'gen_ai.operation.name' => 'invoke_agent', 'gen_ai.output.type' => 'json', 'gen_ai.request.model' => 'claude-test']],
            // The request the tool runner makes.
            ['anthropic.messages.create', [...$everySpan, ...$post, 'gen_ai.operation.name' => 'chat', 'gen_ai.output.type' => 'json', 'gen_ai.request.max_tokens' => 16, 'gen_ai.request.model' => 'claude-test']],
            ['anthropic.sessions.create', ['anthropic.session.environment.id' => 'env_1', ...$everySpan, 'http.request.method' => 'POST', 'http.route' => '/v1/sessions', 'gen_ai.agent.id' => 'agent_1']],
            ['anthropic.messages.batches.create', ['anthropic.message.batch.request_count' => 2, ...$everySpan, 'http.request.method' => 'POST', 'http.route' => '/v1/messages/batches']],
            ['anthropic.sessions.threads.events.list', ['anthropic.session.id' => 'sesn_1', 'anthropic.session.thread.id' => 'sthr_1', ...$everySpan, 'http.request.method' => 'GET', 'http.route' => '/v1/sessions/{session_id}/threads/{thread_id}/events']],
            ['anthropic.sessions.threads.events.list', ['anthropic.session.id' => 'sesn_1', 'anthropic.session.thread.id' => 'sthr_1', ...$everySpan, 'gen_ai.conversation.id' => 'sthr_1', 'http.request.method' => 'GET', 'http.route' => '/v1/sessions/{session_id}/threads/{thread_id}/events']],
        ];
        $this->assertCount(count($expected), $started->spans);
        foreach ($expected as $index => [$name, $attributes]) {
            // The order of a span's attributes says nothing.
            ksort($attributes);
            $this->assertSame([$name, $attributes], $started->spans[$index]);
        }
    }

    #[DataProvider('baseUrls')]
    public function testUrlAttributesAreThoseOfTheRequestWithAPortOnlyWhenTheUrlGivesOne(string $baseUrl, string $scheme, string $full, int $port): void
    {
        $this->transporter->addResponse(self::json(['id' => 'claude-test', 'type' => 'model', 'display_name' => 'Test', 'created_at' => '2026-01-01T00:00:00Z']));
        $client = new Client(apiKey: 'test-api-key', baseUrl: $baseUrl, requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0], openTelemetry: ['tracerProvider' => $this->tracerProvider]);

        $client->models->retrieve('claude-test');

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('GET', $attributes['http.request.method']);
        $this->assertSame('/v1/models/{model_id}', $attributes['http.route']);
        $this->assertSame($scheme, $attributes['url.scheme']);
        $this->assertSame($this->lastRequest()->getUri()->getPath(), $attributes['url.path']);
        $this->assertSame($full, $attributes['url.full']);
        $this->assertArrayNotHasKey('url.query', $attributes);
        // The port of the base URL, or else the port of its scheme: the span always has one.
        $this->assertSame($port, $attributes['server.port']);
    }

    /**
     * @return iterable<string, array{string, string, string, int}>
     */
    public static function baseUrls(): iterable
    {
        yield 'no port, over https' => ['https://api.example.test', 'https', 'https://api.example.test/v1/models/claude-test', 443];

        yield 'no port, over http' => ['http://api.example.test', 'http', 'http://api.example.test/v1/models/claude-test', 80];

        yield 'an explicit port' => ['http://localhost:8080', 'http', 'http://localhost:8080/v1/models/claude-test', 8080];

        yield 'a path and user information' => ['https://user:secret@api.example.test:8443/proxy', 'https', 'https://api.example.test:8443/proxy/v1/models/claude-test', 8443];
    }

    public function testUrlQueryHasOnlyTheParametersTheEndpointDefines(): void
    {
        $page = ['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null, 'next_page' => null];
        $client = $this->client();

        // `beta=true` is part of the path the SDK sends, and `debug` is the application's own: the endpoint defines neither.
        $this->transporter->addResponse(self::json($page));
        $client->beta->files->list(ids: ['a b', 'c'], limit: 2, requestOptions: ['extraQueryParams' => ['debug' => 'yes']]);
        $this->assertSame('beta=true&ids%5B%5D=a%20b&ids%5B%5D=c&limit=2&debug=yes', $this->lastRequest()->getUri()->getQuery());
        // `created_at[gte]` is the name of a parameter, brackets and all.
        $this->transporter->addResponse(self::json($page));
        $client->beta->agents->list(createdAtGte: new \DateTimeImmutable('2026-01-01T00:00:00Z'), requestOptions: ['extraQueryParams' => ['created_at[gt]' => 'not-defined-here']]);
        // Nothing is left of a query that has only what the endpoint does not define.
        $this->transporter->addResponse(self::json($page));
        $client->beta->files->list(requestOptions: ['extraQueryParams' => ['debug' => 'yes']]);
        $this->assertSame('beta=true&debug=yes', $this->lastRequest()->getUri()->getQuery());

        [$files, $agents, $none] = array_map(static fn (ImmutableSpan $span): array => $span->getAttributes()->toArray(), $this->spans());
        $this->assertSame('ids%5B%5D=a%20b&ids%5B%5D=c&limit=2', $files['url.query']);
        // `url.full` has the same query, so it is not the URL that was sent.
        $this->assertSame('https://api.example.test:8443/v1/files?ids%5B%5D=a%20b&ids%5B%5D=c&limit=2', $files['url.full']);
        $this->assertSame('/v1/files', $files['http.route']);
        $this->assertIsString($agents['url.query']);
        $this->assertMatchesRegularExpression('/^created_at%5Bgte%5D=2026-01-01[^&]*$/', $agents['url.query']);
        $this->assertArrayNotHasKey('url.query', $none);
        $this->assertSame('https://api.example.test:8443/v1/files', $none['url.full']);
    }

    public function testUrlQueryOfAWorkspacesListHasIncludeDefault(): void
    {
        $page = ['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null];
        $client = $this->client();

        $this->transporter->addResponse(self::json($page));
        $client->organization->workspaces->list(includeArchived: true, includeDefault: true, limit: 2);
        $this->transporter->addResponse(self::json($page));
        $client->beta->organization->workspaces->list(includeArchived: true, includeDefault: true, limit: 2);

        foreach ($this->spans() as $span) {
            $this->assertSame('include_archived=true&include_default=true&limit=2', $span->getAttributes()->get('url.query'));
        }
        $this->assertCount(2, $this->spans());
    }

    public function testUrlQueryOfAModelsListHasLifecycleAndOfASessionThreadsListHasStatuses(): void
    {
        $client = $this->client();

        $this->transporter->addResponse(self::json(['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null]));
        $client->models->list(lifecycle: ['active', 'retired'], limit: 2);
        $this->transporter->addResponse(self::json(['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null]));
        $client->beta->models->list(lifecycle: ['active', 'retired'], limit: 2);
        $this->transporter->addResponse(self::json(['data' => [], 'next_page' => null]));
        $client->beta->sessions->threads->list('sesn_1', limit: 2, statuses: ['running', 'idle']);

        [$models, $betaModels, $threads] = array_map(static fn (ImmutableSpan $span): mixed => $span->getAttributes()->get('url.query'), $this->spans());
        $this->assertSame('lifecycle%5B%5D=active&lifecycle%5B%5D=retired&limit=2', $models);
        $this->assertSame('lifecycle%5B%5D=active&lifecycle%5B%5D=retired&limit=2', $betaModels);
        $this->assertSame('limit=2&statuses%5B%5D=running&statuses%5B%5D=idle', $threads);
        $this->assertCount(3, $this->spans());
    }

    /**
     * A parameter that filters like a search, or whose value comes from stored content, makes the query content.
     *
     * @param \Closure(Client): mixed $call
     * @param array<string, mixed> $response
     */
    #[DataProvider('queriesThatMayBeContent')]
    public function testUrlQueryWithAParameterWhoseValueIsContentIsRecordedOnlyInContentMode(\Closure $call, array $response, string $route, string $path, string $query, bool $isContent): void
    {
        foreach ([false, true] as $recordsContent) {
            $before = count($this->spans());
            $this->transporter->addResponse(self::json($response));
            $call($this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => $recordsContent ? 'content' : 'metadata_only']]));

            $spans = array_slice($this->spans(), $before);
            $this->assertCount(1, $spans);
            $attributes = $spans[0]->getAttributes()->toArray();
            // The request has the parameter either way: only the span leaves it out.
            $this->assertStringContainsString($query, $this->lastRequest()->getUri()->getQuery());
            $this->assertSame('https', $attributes['url.scheme']);
            $this->assertSame($route, $attributes['http.route']);
            $this->assertSame($path, $attributes['url.path']);
            $this->assertSame(200, $attributes['http.response.status_code']);
            if ($isContent && !$recordsContent) {
                $this->assertArrayNotHasKey('url.query', $attributes);
                $this->assertArrayNotHasKey('url.full', $attributes);
            } else {
                $this->assertSame($query, $attributes['url.query']);
                $this->assertSame("https://api.example.test:8443{$path}?{$query}", $attributes['url.full']);
            }
        }
    }

    /**
     * @return iterable<string, array{\Closure(Client): mixed, array<string, mixed>, string, string, string, bool}>
     */
    public static function queriesThatMayBeContent(): iterable
    {
        $page = ['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null, 'next_page' => null];
        $memories = '/v1/memory_stores/{memory_store_id}/memories';

        yield 'email filters like a search' => [
            static fn (Client $client): mixed => $client->beta->organization->users->list(email: 'ada@example.test', limit: 5),
            $page, '/v1/organizations/users', '/v1/organizations/users', 'email=ada%40example.test&limit=5', true,
        ];

        yield 'path_prefix filters like a search' => [
            static fn (Client $client): mixed => $client->beta->memoryStores->memories->list('memstore_1', limit: 5, pathPrefix: '/notes/'),
            $page, $memories, '/v1/memory_stores/memstore_1/memories', 'limit=5&path_prefix=%2Fnotes%2F', true,
        ];

        yield 'expected_content_sha256 comes from stored content' => [
            static fn (Client $client): mixed => $client->beta->memoryStores->memories->delete('mem_1', memoryStoreID: 'memstore_1', expectedContentSha256: 'abc123'),
            ['id' => 'mem_1', 'type' => 'memory_deleted'], $memories.'/{memory_id}', '/v1/memory_stores/memstore_1/memories/mem_1', 'expected_content_sha256=abc123', true,
        ];

        yield 'any other parameter is no content' => [
            static fn (Client $client): mixed => $client->beta->organization->users->list(limit: 5, roles: ['admin']),
            $page, '/v1/organizations/users', '/v1/organizations/users', 'limit=5&roles%5B%5D=admin', false,
        ];

        $analytics = '/v1/organizations/analytics';

        yield 'filter of the analytics skills list matches names' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->skills->list(filter: ['skill_name:Quarterly'], limit: 5),
            $page, $analytics.'/skills', $analytics.'/skills', 'filter%5B%5D=skill_name%3AQuarterly&limit=5', true,
        ];

        yield 'filter of the analytics plugins list matches names' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->plugins->list(filter: ['plugin_name:Quarterly'], limit: 5),
            $page, $analytics.'/plugins', $analytics.'/plugins', 'filter%5B%5D=plugin_name%3AQuarterly&limit=5', true,
        ];

        yield 'filter of the analytics connectors list matches names' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->connectors->list(filter: ['connector_name:Quarterly'], limit: 5),
            $page, $analytics.'/connectors', $analytics.'/connectors', 'filter%5B%5D=connector_name%3AQuarterly&limit=5', true,
        ];

        yield 'filter of the analytics users list takes only IDs or fixed values' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->users->list(filter: ['user_id:user_1'], limit: 5),
            $page, $analytics.'/users', $analytics.'/users', 'filter%5B%5D=user_id%3Auser_1&limit=5', false,
        ];

        yield 'page of the analytics users list is a cursor that holds an email address' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->users->list(limit: 5, page: 'page_2'),
            $page, $analytics.'/users', $analytics.'/users', 'limit=5&page=page_2', true,
        ];

        yield 'page of the memories list is a cursor that holds a memory path' => [
            static fn (Client $client): mixed => $client->beta->memoryStores->memories->list('memstore_1', limit: 5, page: 'page_2'),
            $page, $memories, '/v1/memory_stores/memstore_1/memories', 'limit=5&page=page_2', true,
        ];

        yield 'page of any other list is no content' => [
            static fn (Client $client): mixed => $client->beta->organization->analytics->skills->list(limit: 5, page: 'page_2'),
            $page, $analytics.'/skills', $analytics.'/skills', 'limit=5&page=page_2', false,
        ];
    }

    /**
     * `filter` is content on the endpoints whose methods say so, such as the list of skill usage, where it matches names. Without content, the span has the value nowhere, and neither does the span of a later page.
     */
    public function testQueryParameterThatIsContentOnOneEndpointIsRecordedOnlyInContentMode(): void
    {
        $query = 'filter%5B%5D=skill_name%3AQuarterly&limit=5';
        $path = '/v1/organizations/analytics/skills';

        foreach (['metadata_only', 'content'] as $contentMode) {
            $this->transporter->addResponse(self::json(['data' => [], 'next_page' => 'page_2']));
            $this->transporter->addResponse(self::json(['data' => [], 'next_page' => null]));
            $first = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => $contentMode]])->beta->organization->analytics->skills->list(filter: ['skill_name:Quarterly'], limit: 5);
            $this->assertStringContainsString($query, $this->lastRequest()->getUri()->getQuery());
            $first->getNextPage();
            $this->assertStringContainsString('page=page_2', $this->lastRequest()->getUri()->getQuery());
            $this->assertStringContainsString('filter%5B%5D=skill_name%3AQuarterly', $this->lastRequest()->getUri()->getQuery());
        }

        $spans = array_map(static fn (ImmutableSpan $span): array => $span->getAttributes()->toArray(), $this->spans());
        $this->assertCount(4, $spans);
        foreach ($spans as $attributes) {
            $this->assertSame($path, $attributes['http.route']);
            $this->assertSame($path, $attributes['url.path']);
        }
        foreach ([$spans[0], $spans[1]] as $metadataOnly) {
            $this->assertArrayNotHasKey('url.query', $metadataOnly);
            $this->assertArrayNotHasKey('url.full', $metadataOnly);
            $this->assertStringNotContainsStringIgnoringCase('Quarterly', json_encode($metadataOnly, JSON_THROW_ON_ERROR));
        }
        $this->assertSame($query, $spans[2]['url.query']);
        $this->assertSame("https://api.example.test:8443{$path}?{$query}", $spans[2]['url.full']);
        $laterPage = $spans[3]['url.query'];
        $this->assertIsString($laterPage);
        $this->assertStringContainsString('filter%5B%5D=skill_name%3AQuarterly', $laterPage);
        $this->assertStringContainsString('page=page_2', $laterPage);
        $this->assertSame("https://api.example.test:8443{$path}?{$laterPage}", $spans[3]['url.full']);
    }

    /**
     * A sent parameter is content when its name always is, whatever the method says, or when the method says it is on its endpoint.
     *
     * @param list<string> $defined
     * @param list<string> $contentOnThisEndpoint
     */
    #[DataProvider('queriesThatAreContentByNameOrByEndpoint')]
    public function testUrlQueryIsContentByTheNameOfAParameterOrByItsEndpoint(string $query, array $defined, array $contentOnThisEndpoint, bool $isContent): void
    {
        $url = Psr17FactoryDiscovery::findUriFactory()->createUri('https://api.example.test/v1/things')->withQuery($query);

        $metadataOnly = Tracing::urlAttributes($url, $defined, contentQueryNames: $contentOnThisEndpoint);
        $content = Tracing::urlAttributes($url, $defined, recordsContent: true, contentQueryNames: $contentOnThisEndpoint);

        $this->assertSame('/v1/things', $metadataOnly['url.path']);
        $this->assertSame('https', $metadataOnly['url.scheme']);
        $this->assertSame($isContent, !array_key_exists('url.query', $metadataOnly));
        $this->assertSame($isContent, !array_key_exists('url.full', $metadataOnly));
        $this->assertSame($query, $content['url.query']);
        $this->assertSame('https://api.example.test/v1/things?'.$query, $content['url.full']);
    }

    /**
     * @return iterable<string, array{string, list<string>, list<string>, bool}>
     */
    public static function queriesThatAreContentByNameOrByEndpoint(): iterable
    {
        yield 'a name that always is content, when the method names none' => ['email=ada%40example.test&limit=5', ['email', 'limit'], [], true];

        yield 'a name that always is content, when the method names another' => ['path_prefix=%2Fnotes%2F', ['filter', 'path_prefix'], ['filter'], true];

        yield 'a name the method says is content' => ['filter%5B%5D=skill_name%3AQuarterly&limit=5', ['filter', 'limit'], ['filter'], true];

        yield 'the same name on an endpoint whose method does not' => ['filter%5B%5D=user_id%3Auser_1&limit=5', ['filter', 'limit'], [], false];

        yield 'a name the method says is content but the request leaves out' => ['limit=5', ['filter', 'limit'], ['filter'], false];
    }

    /**
     * A method of the organization resource has a call span like any other, and `email`, which its list of members defines, makes the query content.
     */
    public function testOrganizationMethodHasACallSpanWhoseQueryIsRecordedOnlyInContentMode(): void
    {
        $page = ['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null, 'next_page' => null];
        $query = 'email=ada%40example.test&limit=5';

        foreach (['metadata_only', 'content'] as $contentMode) {
            $this->transporter->addResponse(self::json($page));
            $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => $contentMode]])->organization->users->list(email: 'ada@example.test', limit: 5);
            $this->assertSame($query, $this->lastRequest()->getUri()->getQuery());
        }

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame('anthropic.organization.users.list', $span->getName());
            $this->assertSame('GET', $span->getAttributes()->get('http.request.method'));
            $this->assertSame('/v1/organizations/users', $span->getAttributes()->get('http.route'));
            $this->assertSame('/v1/organizations/users', $span->getAttributes()->get('url.path'));
        }
        [$metadataOnly, $content] = array_map(static fn (ImmutableSpan $span): array => $span->getAttributes()->toArray(), $spans);
        $this->assertArrayNotHasKey('url.query', $metadataOnly);
        $this->assertArrayNotHasKey('url.full', $metadataOnly);
        $this->assertSame($query, $content['url.query']);
        $this->assertSame("https://api.example.test:8443/v1/organizations/users?{$query}", $content['url.full']);
    }

    /**
     * @param list<string> $defined
     */
    #[DataProvider('queries')]
    public function testUrlQueryKeepsTheDefinedParametersAsTheyWereSent(string $query, array $defined, ?string $expected): void
    {
        $url = Psr17FactoryDiscovery::findUriFactory()->createUri('https://api.example.test/v1/things')->withQuery($query);

        $attributes = Tracing::urlAttributes($url, $defined);

        $this->assertSame($expected, $attributes['url.query'] ?? null);
        $this->assertSame('https://api.example.test/v1/things'.(null === $expected ? '' : '?'.$expected), $attributes['url.full']);
    }

    /**
     * @return iterable<string, array{string, list<string>, string|null}>
     */
    public static function queries(): iterable
    {
        yield 'no query' => ['', ['limit'], null];

        yield 'nothing defined' => ['beta=true&limit=1', [], null];

        yield 'only undefined parameters' => ['beta=true&debug=1', ['limit'], null];

        yield 'the order and the encoding as sent' => ['page=a%2Fb&beta=true&limit=1&q=x+y&after_id=%41', ['after_id', 'limit', 'page'], 'page=a%2Fb&limit=1&after_id=%41'];

        yield 'a name that is percent-encoded' => ['%6Cimit=1&li%6Dit=2', ['limit'], '%6Cimit=1&li%6Dit=2'];

        yield 'the items of a list as `name[]`, not those with an index or a key' => ['ids%5B%5D=a&ids%5b%5d=b&ids%5B0%5D=c&ids%5B1%5D%5Bx%5D=d&ids%5B%5D%5B%5D=e&idsx=f', ['ids'], 'ids%5B%5D=a&ids%5b%5d=b'];

        yield 'a name that is defined with its brackets' => ['created_at%5Bgte%5D=1&created_at%5Blte%5D=2&created_at%5Blt%5D=3', ['created_at[gte]', 'created_at[lte]'], 'created_at%5Bgte%5D=1&created_at%5Blte%5D=2'];

        yield 'a name without brackets does not cover its keys' => ['created_at%5Bgte%5D=1', ['created_at'], null];

        yield 'a key that the application adds to a defined name' => ['limit%5Bx%5D=1&limit=2', ['limit'], 'limit=2'];

        yield 'a name is matched whole' => ['limits=1&Limit=2&lim=3&=4&&limit', ['limit'], 'limit'];

        yield 'a value that holds an equals sign' => ['page=a=b&x=limit=1', ['page', 'limit'], 'page=a=b'];
    }

    public function testRetriesKeepTheUrlOfTheFirstRequestAndAreCountedAsResends(): void
    {
        $busy = ['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'busy']];
        $this->transporter->addResponse(self::json($busy, status: 529, headers: ['retry-after-ms' => '1']));
        $this->transporter->addResponse(self::json($busy, status: 529, headers: ['retry-after-ms' => '1']));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        // Each attempt goes to a path of its own, as a middleware may send it.
        $middleware = static function (RequestInterface $request, \Closure $next): ResponseInterface {
            $response = $next($request->withUri($request->getUri()->withPath('/attempt/'.$request->getHeaderLine('X-Stainless-Retry-Count'))));
            assert($response instanceof ResponseInterface);

            return $response;
        };
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 2, 'middleware' => [$middleware]], openTelemetry: ['tracerProvider' => $this->tracerProvider]);

        $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        $this->assertSame(['/attempt/0', '/attempt/1', '/attempt/2'], array_map(static fn (RequestInterface $request): string => $request->getUri()->getPath(), $this->transporter->getRequests()));
        $attributes = $this->onlySpan()->getAttributes()->toArray();
        // The path is the one that was sent, after the middleware, and the route is the endpoint's.
        $this->assertSame('/attempt/0', $attributes['url.path']);
        $this->assertSame('https://api.example.test/attempt/0', $attributes['url.full']);
        $this->assertSame('/v1/messages', $attributes['http.route']);
        $this->assertSame(2, $attributes['http.request.resend_count']);
        $this->assertSame(200, $attributes['http.response.status_code']);
    }

    public function testRequestThatAMiddlewareSendsAgainIsAResend(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        // A fallback sends the request again within the same attempt, here to another path.
        $middleware = static function (RequestInterface $request, \Closure $next): ResponseInterface {
            $next($request);
            $response = $next($request->withUri($request->getUri()->withPath('/fallback')));
            assert($response instanceof ResponseInterface);

            return $response;
        };

        $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', requestOptions: ['middleware' => [$middleware]]);

        $this->assertCount(2, $this->transporter->getRequests());
        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('/v1/messages', $attributes['url.path']);
        $this->assertSame(1, $attributes['http.request.resend_count']);
    }

    public function testRedirectLeavesTheUrlAndTheMethodOfTheFirstRequest(): void
    {
        // A 303 is followed with a GET.
        $this->transporter->addResponse(self::json([], 303, ['Location' => 'https://elsewhere.example.test:9443/v2/messages?token=secret']));
        $this->transporter->addResponse(self::json(self::MESSAGE));

        $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/v2/messages', $this->lastRequest()->getUri()->getPath());
        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('POST', $attributes['http.request.method']);
        $this->assertSame('https', $attributes['url.scheme']);
        $this->assertSame('/v1/messages', $attributes['url.path']);
        $this->assertSame('https://api.example.test:8443/v1/messages', $attributes['url.full']);
        $this->assertArrayNotHasKey('url.query', $attributes);
        // The request that follows the redirect is one the SDK sent after the first.
        $this->assertSame(1, $attributes['http.request.resend_count']);
    }

    public function testCallThatFailsOnItsOnlyRequestHasItsUrlAndNoResendCount(): void
    {
        $this->transporter->addException(new NetworkException('connection refused', Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', 'https://api.example.test:8443/v1/messages')));

        try {
            $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $this->fail('expected an APIConnectionException');
        } catch (APIConnectionException) {
        }

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('connection_error', $attributes['error.type']);
        $this->assertSame('/v1/messages', $attributes['url.path']);
        $this->assertSame('https://api.example.test:8443/v1/messages', $attributes['url.full']);
        $this->assertArrayNotHasKey('http.request.resend_count', $attributes);
    }

    public function testCallThatAnErrorResponseFailsHasItsUrlPath(): void
    {
        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'not_found_error', 'message' => 'no such model']], 404));

        try {
            // A value that is no ID goes into the path, and onto the span, as it is.
            $this->client()->models->retrieve('latest');
            $this->fail('expected a NotFoundException');
        } catch (NotFoundException) {
        }

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('not_found_error', $attributes['error.type']);
        $this->assertSame(404, $attributes['http.response.status_code']);
        $this->assertSame('/v1/models/{model_id}', $attributes['http.route']);
        $this->assertSame('latest', $attributes['anthropic.model.id']);
        $this->assertSame('/v1/models/latest', $attributes['url.path']);
        $this->assertSame('https://api.example.test:8443/v1/models/latest', $attributes['url.full']);
    }

    public function testContentAttributesOnlyInContentMode(): void
    {
        $params = ['maxTokens' => 16, 'system' => 'Be brief.', 'messages' => [
            ['role' => 'user', 'content' => 'Hello'],
            ['role' => 'assistant', 'content' => [['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => ['q' => 'x']]]],
            ['role' => 'user', 'content' => [['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => 'found'], ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => 'image/png', 'data' => 'AAAA']], ['type' => 'document', 'source' => ['type' => 'text', 'media_type' => 'text/plain', 'data' => 'BBBB']]]],
        ], 'model' => 'claude-test'];

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->client()->messages->create(...$params);
        $this->assertNull($this->onlySpan()->getAttributes()->get('gen_ai.input.messages'));

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(...$params);
        $attributes = $this->spans()[1]->getAttributes()->toArray();
        $this->assertSame([['type' => 'text', 'content' => 'Be brief.']], self::decode($attributes['gen_ai.system_instructions']));
        $this->assertSame([
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]],
            ['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => 'x']]]],
            // A block that has no part of its own is a part with its type only, prefixed.
            ['role' => 'user', 'parts' => [['type' => 'tool_call_response', 'id' => 'toolu_1', 'response' => [['type' => 'text', 'text' => 'found']]], ['type' => 'anthropic_image'], ['type' => 'anthropic_document']]],
        ], self::decode($attributes['gen_ai.input.messages']));
        $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi there']]]], self::decode($attributes['gen_ai.output.messages']));

        // The environment variable applies to a client that is given no option.
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=Content');
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->clientWithoutTheOption()->messages->create(...$params);
        $this->assertNotNull($this->spans()[2]->getAttributes()->get('gen_ai.input.messages'));
    }

    public function testToolResultContentIsItsContentBlocks(): void
    {
        $text = ['type' => 'text', 'text' => 'found', 'citations' => [['type' => 'char_location', 'cited_text' => 'found', 'document_index' => 0, 'document_title' => 'Notes', 'start_char_index' => 0, 'end_char_index' => 5]], 'cache_control' => ['type' => 'ephemeral']];
        $searchResult = ['type' => 'search_result', 'source' => 'https://example.com', 'title' => 'Example', 'content' => [['type' => 'text', 'text' => 'body']], 'citations' => ['enabled' => true]];
        $image = ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => 'image/png', 'data' => 'AAAA']];
        $this->transporter->addResponse(self::json(self::MESSAGE));

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => [
            ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => 'found'],
            ['type' => 'tool_result', 'tool_use_id' => 'toolu_2', 'content' => [$text, $searchResult, $image]],
            ['type' => 'tool_result', 'tool_use_id' => 'toolu_3'],
            ['type' => 'tool_result', 'tool_use_id' => 'toolu_4', 'content' => [['type' => 'text', 'text' => 'found', 'citations' => [['type' => 'web_search_result_location', 'cited_text' => 'found', 'url' => 'https://example.com', 'title' => 'Example', 'encrypted_index' => 'SEALED']]]]],
        ]]], model: 'claude-test');

        // A text block and a search result block keep all their fields, except those whose name starts with
        // `encrypted_`. Any other block keeps only its type.
        $this->assertSame([['role' => 'user', 'parts' => [
            ['type' => 'tool_call_response', 'id' => 'toolu_1', 'response' => [['type' => 'text', 'text' => 'found']]],
            ['type' => 'tool_call_response', 'id' => 'toolu_2', 'response' => [$text, $searchResult, ['type' => 'image']]],
            ['type' => 'tool_call_response', 'id' => 'toolu_3', 'response' => []],
            ['type' => 'tool_call_response', 'id' => 'toolu_4', 'response' => [['type' => 'text', 'text' => 'found', 'citations' => [['type' => 'web_search_result_location', 'cited_text' => 'found', 'url' => 'https://example.com', 'title' => 'Example']]]]],
        ]]], self::decode($this->onlySpan()->getAttributes()->get('gen_ai.input.messages')));
    }

    public function testRequestIsRecordedFromItsDocumentedFieldsOnlyAndItsContentOnlyInContentMode(): void
    {
        // The call fails, so the span has only what the method recorded from its arguments when it started it.
        $error = ['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']];
        $tools = [['name' => 'SENTINEL_tool', 'description' => 'SENTINEL description', 'input_schema' => ['type' => 'object']]];
        $params = ['maxTokens' => 16, 'system' => 'SENTINEL system', 'messages' => [['role' => 'user', 'content' => 'SENTINEL message']], 'model' => 'claude-test', 'tools' => $tools, 'metadata' => ['userID' => 'SENTINEL_user'], 'stopSequences' => ['SENTINEL stop'], 'userProfileID' => 'SENTINEL_profile', 'workspaceID' => 'SENTINEL_workspace', 'temperature' => 0.5, 'thinking' => ['type' => 'enabled', 'budgetTokens' => 1024], 'outputConfig' => ['format' => ['type' => 'json_schema', 'schema' => ['type' => 'object', 'description' => 'SENTINEL schema']]]];
        $calls = [
            static fn (Client $client) => $client->messages->create(...$params),
            static fn (Client $client) => $client->beta->messages->create(...$params),
            static fn (Client $client) => $client->beta->messages->createStream(...$params),
            static fn (Client $client) => $client->beta->messages->countTokens(messages: $params['messages'], model: 'claude-test', system: 'SENTINEL system', tools: $tools),
        ];
        $run = function (Client $client) use ($calls, $error): void {
            foreach ($calls as $call) {
                $this->transporter->addResponse(self::json($error, status: 429));

                try {
                    $call($client);
                    $this->fail('expected a RateLimitException');
                } catch (RateLimitException) {
                }
            }
        };

        $run($this->client());
        $metadataOnly = $this->spans();
        $this->assertCount(4, $metadataOnly);
        foreach ($metadataOnly as $span) {
            $attributes = $span->getAttributes()->toArray();
            $this->assertStringNotContainsString('SENTINEL', json_encode($attributes, JSON_THROW_ON_ERROR), $span->getName());
            $this->assertSame([], array_diff(array_keys($attributes), [
                'gen_ai.operation.name', 'gen_ai.provider.name', 'gen_ai.request.model', 'gen_ai.request.max_tokens', 'gen_ai.request.temperature', 'gen_ai.request.stream', 'gen_ai.output.type',
                'anthropic.thinking.type', 'anthropic.thinking.budget_tokens', 'anthropic.beta', 'server.address', 'server.port', 'http.response.status_code', 'error.type',
                'http.request.method', 'http.route', 'url.scheme', 'url.path', 'url.full',
            ]), $span->getName());
        }
        $this->assertSame('enabled', $metadataOnly[0]->getAttributes()->get('anthropic.thinking.type'));
        $this->assertSame(1024, $metadataOnly[0]->getAttributes()->get('anthropic.thinking.budget_tokens'));
        $this->assertSame('json', $metadataOnly[0]->getAttributes()->get('gen_ai.output.type'));

        $run($this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]));
        $content = array_slice($this->spans(), 4);
        foreach (array_slice($content, 0, 3) as $span) {
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame([['type' => 'text', 'content' => 'SENTINEL system']], self::decode($attributes['gen_ai.system_instructions']));
            $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'SENTINEL message']]]], self::decode($attributes['gen_ai.input.messages']));
            $this->assertSame(['SENTINEL stop'], $attributes['gen_ai.request.stop_sequences']);
            // The system prompt, the stop sequences and the messages are the only content. The tools, the metadata and the header parameters are no attribute.
            unset($attributes['gen_ai.system_instructions'], $attributes['gen_ai.input.messages'], $attributes['gen_ai.request.stop_sequences']);
            $this->assertStringNotContainsString('SENTINEL', json_encode($attributes, JSON_THROW_ON_ERROR), $span->getName());
        }
        // `count_tokens` records no content in either mode.
        $this->assertStringNotContainsString('SENTINEL', json_encode($content[3]->getAttributes()->toArray(), JSON_THROW_ON_ERROR));
    }

    public function testOutputTypeIsJsonWhenTheRequestSetsAJsonOutputFormat(): void
    {
        $format = ['type' => 'json_schema', 'schema' => ['type' => 'object', 'properties' => ['answer' => ['type' => 'string']]]];
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];
        $client = $this->client();
        $calls = [
            'json' => static fn () => $client->messages->create(...$params, outputConfig: ['format' => $format]),
            'json beta' => static fn () => $client->beta->messages->create(...$params, outputConfig: ['format' => $format]),
            'json deprecated' => static fn () => $client->beta->messages->create(...$params, outputFormat: $format),
            'json streamed' => static function () use ($client, $params, $format): void {
                foreach ($client->messages->createStream(...$params, outputConfig: ['format' => $format]) as $event);
            },
            'effort only' => static fn () => $client->messages->create(...$params, outputConfig: ['effort' => 'low']),
            'none' => static fn () => $client->messages->create(...$params),
        ];

        foreach ($calls as $name => $call) {
            $this->transporter->addResponse('json streamed' === $name ? self::sse(self::streamEvents()) : self::json([...self::MESSAGE, 'content' => [['type' => 'text', 'text' => '{"answer":"hi"}']]]));
            $call();
        }

        $types = array_map(static fn (ImmutableSpan $span): mixed => $span->getAttributes()->get('gen_ai.output.type'), $this->spans());
        // Metadata: the client does not record content.
        $this->assertSame(['json', 'json', 'json', 'json', null, null], $types);
        // The typed parameters take no other format. One that is not the JSON format sets no output type.
        $this->assertFalse(Tracing::setsJsonOutputFormat(['output_config' => ['format' => ['type' => 'text']]]));
    }

    public function testStreamedOutputContentIsThatOfTheSameResponseNotStreamed(): void
    {
        $message = [...self::MESSAGE, 'content' => [['type' => 'text', 'text' => 'Hi'], ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => ['q' => 'x']]], 'stop_reason' => 'tool_use'];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];

        foreach ([$client->messages, $client->beta->messages] as $messages) {
            $this->transporter->addResponse(self::json($message));
            $messages->create(...$params);
            $this->transporter->addResponse(self::sse(self::toolUseStreamEvents()));
            foreach ($messages->createStream(...$params) as $event);
        }

        $spans = $this->spans();
        $this->assertCount(4, $spans);
        $expected = [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi'], ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => 'x']]]]];
        foreach ([[$spans[0], $spans[1]], [$spans[2], $spans[3]]] as [$unary, $streamed]) {
            $this->assertNull($unary->getAttributes()->get('gen_ai.request.stream'));
            $this->assertTrue($streamed->getAttributes()->get('gen_ai.request.stream'));
            $this->assertSame($expected, self::decode($unary->getAttributes()->get('gen_ai.output.messages')));
            $this->assertSame($unary->getAttributes()->get('gen_ai.output.messages'), $streamed->getAttributes()->get('gen_ai.output.messages'));
            $this->assertSame($unary->getAttributes()->get('gen_ai.input.messages'), $streamed->getAttributes()->get('gen_ai.input.messages'));
            $this->assertSame('tool_use', $streamed->getAttributes()->get('anthropic.message.stop_reason'));
            $this->assertSame(StatusCode::STATUS_OK, $streamed->getStatus()->getCode());
        }
    }

    public function testStreamedContentIsNotRecordedOutsideContentMode(): void
    {
        $this->transporter->addResponse(self::sse(self::toolUseStreamEvents()));

        $stream = $this->client()->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        foreach ($stream as $event);

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertArrayNotHasKey('gen_ai.output.messages', $attributes);
        $this->assertArrayNotHasKey('gen_ai.input.messages', $attributes);
        $this->assertArrayNotHasKey('anthropic.content.truncated', $attributes);
        $this->assertSame('tool_use', $attributes['anthropic.message.stop_reason']);
        $this->assertSame(7, $attributes['gen_ai.usage.output_tokens']);
    }

    public function testThinkingIsAReasoningPartWithoutItsSignature(): void
    {
        $content = [['type' => 'thinking', 'thinking' => 'Let me think', 'signature' => 'SIGNED'], ['type' => 'thinking', 'thinking' => '', 'signature' => 'SIGNED'], ['type' => 'redacted_thinking', 'data' => 'SEALED'], ['type' => 'text', 'text' => 'Hi']];
        $events = [
            ['type' => 'message_start', 'message' => [...self::MESSAGE, 'content' => [], 'stop_reason' => null]],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'thinking', 'thinking' => '', 'signature' => '']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'thinking_delta', 'thinking' => 'Let me ']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'thinking_delta', 'thinking' => 'think']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'signature_delta', 'signature' => 'SIGNED']],
            ['type' => 'content_block_stop', 'index' => 0],
            ['type' => 'content_block_start', 'index' => 1, 'content_block' => ['type' => 'thinking', 'thinking' => '', 'signature' => '']],
            ['type' => 'content_block_delta', 'index' => 1, 'delta' => ['type' => 'signature_delta', 'signature' => 'SIGNED']],
            ['type' => 'content_block_stop', 'index' => 1],
            ['type' => 'content_block_start', 'index' => 2, 'content_block' => ['type' => 'redacted_thinking', 'data' => 'SEALED']],
            ['type' => 'content_block_stop', 'index' => 2],
            ['type' => 'content_block_start', 'index' => 3, 'content_block' => ['type' => 'text', 'text' => '']],
            ['type' => 'content_block_delta', 'index' => 3, 'delta' => ['type' => 'text_delta', 'text' => 'Hi']],
            ['type' => 'content_block_stop', 'index' => 3],
            ['type' => 'message_delta', 'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]],
            ['type' => 'message_stop'],
        ];
        // The request sends the thinking of an earlier turn back.
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello'], ['role' => 'assistant', 'content' => $content], ['role' => 'user', 'content' => 'Go on']], 'model' => 'claude-test'];

        foreach ([$this->client(), $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])] as $client) {
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => $content]));
            $client->messages->create(...$params);
            $this->transporter->addResponse(self::sse($events));
            foreach ($client->messages->createStream(...$params) as $event);
        }

        [$unaryWithout, $streamedWithout, $unary, $streamed] = $this->spans();
        foreach ([$unaryWithout, $streamedWithout] as $span) {
            $this->assertStringNotContainsString('Let me think', json_encode($span->getAttributes()->toArray(), JSON_THROW_ON_ERROR));
        }
        // A thinking block that the API returned without its thinking is a part with empty content.
        $parts = [['type' => 'reasoning', 'content' => 'Let me think'], ['type' => 'reasoning', 'content' => ''], ['type' => 'anthropic_redacted_thinking'], ['type' => 'text', 'content' => 'Hi']];
        foreach ([$unary, $streamed] as $span) {
            $this->assertSame([['role' => 'assistant', 'parts' => $parts]], self::decode($span->getAttributes()->get('gen_ai.output.messages')));
            $this->assertSame(['role' => 'assistant', 'parts' => $parts], self::decode($span->getAttributes()->get('gen_ai.input.messages'))[1]);
            $attributes = json_encode($span->getAttributes()->toArray(), JSON_THROW_ON_ERROR);
            $this->assertStringNotContainsString('SIGNED', $attributes);
            $this->assertStringNotContainsString('signature', $attributes);
            $this->assertStringNotContainsString('SEALED', $attributes);
        }
    }

    public function testStreamWithABlockIndexOutOfOrderRecordsNoOutputContent(): void
    {
        $events = self::toolUseStreamEvents();
        // A block that does not take the next index: the accumulator refuses it, so the span gets none of the output.
        array_splice($events, 3, 0, [['type' => 'content_block_start', 'index' => 999999, 'content_block' => ['type' => 'text', 'text' => 'stray']]]);
        $this->transporter->addResponse(self::sse($events));

        $stream = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $types = [];
        foreach ($stream as $event) {
            $types[] = $event->type;
        }

        // The application still reads every event.
        $this->assertSame(array_column($events, 'type'), $types);
        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertArrayNotHasKey('gen_ai.output.messages', $attributes);
        $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($attributes['gen_ai.input.messages']));
        $this->assertSame('tool_use', $attributes['anthropic.message.stop_reason']);
        $this->assertSame(7, $attributes['gen_ai.usage.output_tokens']);
    }

    /**
     * A stream that ends before `message_stop`, however it ends, has the Message as far as it was accumulated.
     *
     * @param list<array<string, mixed>> $events
     * @param list<array<string, mixed>> $parts
     */
    #[DataProvider('streamEndingBeforeMessageStopCases')]
    public function testStreamThatEndsBeforeMessageStopHasThePartialMessageAsItsOutputContent(array $events, string $ending, array $parts, string $status, ?string $errorType): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        foreach ([$client->messages, $client->beta->messages] as $messages) {
            $this->transporter->addResponse(self::sse($events));
            $stream = $messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $read = 0;
            $thrown = null;

            try {
                foreach ($stream as $event) {
                    if (++$read === count($events) && 'read' !== $ending) {
                        break;
                    }
                }
            } catch (APIStatusException $e) {
                $thrown = $e;
            }
            if ('close' === $ending) {
                $stream->close();
            }
            unset($stream, $event);
            gc_collect_cycles();
            $this->assertSame('error' === ($events[count($events) - 1]['type'] ?? null), null !== $thrown);
        }

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame($status, $span->getStatus()->getCode());
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame($errorType, $attributes['error.type'] ?? null);
            $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($attributes['gen_ai.input.messages']));
            $output = $attributes['gen_ai.output.messages'];
            $this->assertIsString($output);
            $this->assertSame([['role' => 'assistant', 'parts' => $parts]], self::decode($output));
            // The arguments of a tool use whose input is still being streamed are an empty object, not an empty list.
            $this->assertStringNotContainsString('"arguments":[]', $output);
            // The stop reason and the output tokens come with `message_delta`: a stream that ends before it has neither.
            $finalized = in_array('message_delta', array_column($events, 'type'), true);
            $this->assertSame($finalized ? 'tool_use' : null, $attributes['anthropic.message.stop_reason'] ?? null);
            $this->assertSame($finalized ? 7 : null, $attributes['gen_ai.usage.output_tokens'] ?? null);
            $this->assertSame('msg_1', $attributes['gen_ai.response.id']);
        }
    }

    /**
     * @return iterable<string, array{list<array<string, mixed>>, string, list<array<string, mixed>>, string, string|null}>
     */
    public static function streamEndingBeforeMessageStopCases(): iterable
    {
        $text = ['type' => 'text', 'content' => 'Hi'];
        $toolCall = ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => []];
        $afterTextDelta = self::streamEvents(stop: false);
        // Up to the first half of the tool use's input.
        $insideToolUse = array_slice(self::toolUseStreamEvents(), 0, 7);
        $beforeMessageStop = array_slice(self::toolUseStreamEvents(), 0, -1);
        $error = ['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'busy']];

        yield 'the API ends the stream after a text delta' => [$afterTextDelta, 'read', [$text], StatusCode::STATUS_ERROR, 'api_error'];

        yield 'the API ends the stream inside a tool use' => [$insideToolUse, 'read', [$text, $toolCall], StatusCode::STATUS_ERROR, 'api_error'];

        yield 'the API ends the stream before any content' => [array_slice($afterTextDelta, 0, 1), 'read', [], StatusCode::STATUS_ERROR, 'api_error'];

        yield 'the API ends the stream after message_delta' => [$beforeMessageStop, 'read', [$text, [...$toolCall, 'arguments' => ['q' => 'x']]], StatusCode::STATUS_ERROR, 'api_error'];

        yield 'an error event after a text delta' => [[...$afterTextDelta, $error], 'read', [$text], StatusCode::STATUS_ERROR, 'overloaded_error'];

        yield 'an error event inside a tool use' => [[...$insideToolUse, $error], 'read', [$text, $toolCall], StatusCode::STATUS_ERROR, 'overloaded_error'];

        yield 'the application closes the stream after a text delta' => [$afterTextDelta, 'close', [$text], StatusCode::STATUS_UNSET, null];

        yield 'the application closes the stream inside a tool use' => [$insideToolUse, 'close', [$text, $toolCall], StatusCode::STATUS_UNSET, null];

        yield 'the application closes the stream after message_delta' => [$beforeMessageStop, 'close', [$text, [...$toolCall, 'arguments' => ['q' => 'x']]], StatusCode::STATUS_UNSET, null];

        yield 'the application drops the stream after a text delta' => [$afterTextDelta, 'drop', [$text], StatusCode::STATUS_UNSET, null];

        yield 'the application drops the stream inside a tool use' => [$insideToolUse, 'drop', [$text, $toolCall], StatusCode::STATUS_UNSET, null];
    }

    /**
     * Without `message_start` nothing was accumulated, and an event that the accumulator refuses leaves it with a
     * Message that may be wrong.
     *
     * @param list<array<string, mixed>> $events
     */
    #[DataProvider('streamWithoutAnAccumulatedMessageCases')]
    public function testStreamThatEndsBeforeMessageStopWithoutAnAccumulatedMessageHasNoOutputContent(array $events, bool $content = true): void
    {
        $this->transporter->addResponse(self::sse($events));
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => $content ? 'content' : 'metadata_only']]);

        try {
            foreach ($client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test') as $event);
        } catch (APIStatusException) {
        }

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertArrayNotHasKey('gen_ai.output.messages', $attributes);
        $this->assertSame($content, array_key_exists('gen_ai.input.messages', $attributes));
    }

    /**
     * @return iterable<string, array{0: list<array<string, mixed>>, 1?: bool}>
     */
    public static function streamWithoutAnAccumulatedMessageCases(): iterable
    {
        $events = self::streamEvents(stop: false);

        yield 'no event' => [[]];

        yield 'an error event first' => [[['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'busy']]]];

        yield 'content without message_start' => [array_slice($events, 1)];

        yield 'a block index out of order' => [[...$events, ['type' => 'content_block_start', 'index' => 999999, 'content_block' => ['type' => 'text', 'text' => 'stray']]]];

        yield 'outside content mode, where nothing accumulates the stream' => [$events, false];
    }

    public function testStopSequencesAreContentAndAnEmptyListIsAbsent(): void
    {
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test'];
        $content = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->client()->messages->create(...$params, stopSequences: ['END', 'STOP']);
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $content->messages->create(...$params, stopSequences: ['END', 'STOP']);
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        foreach ($content->beta->messages->createStream(...$params, stopSequences: ['END', 'STOP']) as $event);
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $content->messages->create(...$params, stopSequences: []);
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $content->messages->create(...$params);

        [$metadataOnly, $unary, $streamed, $empty, $unset] = $this->spans();
        $this->assertNull($metadataOnly->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertSame(['END', 'STOP'], $unary->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertSame(['END', 'STOP'], $streamed->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertNull($empty->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertNull($unset->getAttributes()->get('gen_ai.request.stop_sequences'));
    }

    public function testStopSequenceThatIsNotUtf8LeavesOutOnlyTheStopSequences(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();
        $system = [['type' => 'text', 'content' => 'Be brief.']];
        $messages = [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]];
        $output = ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi there']]];

        // An exporter would fail on the second one.
        Content::setMessageContentAttributes($span, $system, $messages, [$output], ['END', "\xB1\x31"]);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertArrayNotHasKey('gen_ai.request.stop_sequences', $attributes);
        $this->assertSame($system, self::decode($attributes['gen_ai.system_instructions']));
        $this->assertSame($messages, self::decode($attributes['gen_ai.input.messages']));
        $this->assertSame([$output], self::decode($attributes['gen_ai.output.messages']));
        $this->assertArrayNotHasKey('anthropic.content.truncated', $attributes);
    }

    public function testStopSequencesThatFitCountTowardTheLimitByTheLengthOfTheirStringsAndStayWhole(): void
    {
        $messages = [
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => str_repeat('m', 200)]]],
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'x']]],
        ];
        $room = Content::LIMIT - strlen(json_encode($messages, JSON_THROW_ON_ERROR)) - strlen('STOP');
        $tracer = $this->tracerProvider->getTracer('test');

        // The strings and the input messages fill the limit exactly, and one more byte exceeds it.
        foreach ([$room, $room + 1] as $length) {
            $span = $tracer->spanBuilder('chat')->startSpan();
            Content::setMessageContentAttributes($span, null, $messages, null, [str_repeat('e', $length), 'STOP']);
            $span->end();
        }

        [$fits, $over] = $this->spans();
        $this->assertSame($messages, self::decode($fits->getAttributes()->get('gen_ai.input.messages')));
        $this->assertNull($fits->getAttributes()->get('anthropic.content.truncated'));
        $this->assertSame([str_repeat('e', $room), 'STOP'], $fits->getAttributes()->get('gen_ai.request.stop_sequences'));
        // The stop sequences stay whole, and the oldest message loses its part.
        $this->assertSame([str_repeat('e', $room + 1), 'STOP'], $over->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertSame([['role' => 'user', 'parts' => []], $messages[1]], self::decode($over->getAttributes()->get('gen_ai.input.messages')));
        $this->assertTrue($over->getAttributes()->get('anthropic.content.truncated'));
    }

    public function testStreamedOutputCountsTowardTheLimitThatRemovesTheOldestInputParts(): void
    {
        // Three deltas of 200 kB make an output that fits in 0.75 MB, but not with all of the input.
        $piece = str_repeat('x', 200_000);
        $big = str_repeat('y', 100_000);
        $events = [
            ['type' => 'message_start', 'message' => [...self::MESSAGE, 'content' => [], 'stop_reason' => null]],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']],
            ...array_fill(0, 3, ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => $piece]]),
            ['type' => 'content_block_stop', 'index' => 0],
            ['type' => 'message_delta', 'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]],
            ['type' => 'message_stop'],
        ];
        $messages = [
            ['role' => 'user', 'content' => "1{$big}"],
            ['role' => 'assistant', 'content' => "2{$big}"],
            ['role' => 'user', 'content' => '3'],
        ];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        // The whole stream, and one that the API ends after the last delta.
        foreach ([$events, array_slice($events, 0, 5)] as $sent) {
            $this->transporter->addResponse(self::sse($sent));
            foreach ($client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
        }

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $attributes = $span->getAttributes()->toArray();
            // The output stays whole, as it would were the response not streamed. The oldest input message loses its part and stays.
            $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => str_repeat($piece, 3)]]]], self::decode($attributes['gen_ai.output.messages']));
            $this->assertSame([['role' => 'user', 'parts' => []], ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => "2{$big}"]]], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => '3']]]], self::decode($attributes['gen_ai.input.messages']));
            $this->assertTrue($attributes['anthropic.content.truncated']);
        }
    }

    public function testContentOverTheLimitRemovesThePartsOfTheOldestInputMessages(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $big = str_repeat('x', 300_000);
        $messages = [
            ['role' => 'user', 'content' => "1{$big}"],
            ['role' => 'assistant', 'content' => "2{$big}"],
            ['role' => 'user', 'content' => "3{$big}"],
            ['role' => 'assistant', 'content' => '4'],
        ];

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $input = self::decode($attributes['gen_ai.input.messages']);
        // Three of the parts exceed 0.75 MB, and two fit. The message that lost its part stays, and nothing in the content marks the removal.
        $this->assertCount(4, $input);
        $this->assertSame(['role' => 'user', 'parts' => []], $input[0]);
        $this->assertSame(['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => "2{$big}"]]], $input[1]);
        $this->assertTrue($attributes['anthropic.content.truncated']);
        $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi there']]]], self::decode($attributes['gen_ai.output.messages']));
    }

    public function testServerAndMcpToolBlocksAreToolCallsAndTheirResults(): void
    {
        $webSearchResult = ['type' => 'web_search_result', 'url' => 'https://example.com', 'title' => 'Example', 'encrypted_content' => 'SEALED', 'page_age' => '1 day'];
        $codeExecutionResult = ['type' => 'code_execution_result', 'stdout' => '4', 'stderr' => '', 'return_code' => 0, 'content' => [['type' => 'code_execution_output', 'file_id' => 'file_1']]];
        $content = [
            ['type' => 'server_tool_use', 'id' => 'srvtoolu_1', 'name' => 'web_search', 'input' => ['query' => 'x']],
            ['type' => 'web_search_tool_result', 'tool_use_id' => 'srvtoolu_1', 'content' => [$webSearchResult]],
            ['type' => 'mcp_tool_use', 'id' => 'mcptoolu_1', 'name' => 'echo', 'server_name' => 'notes', 'input' => ['text' => 'hi']],
            ['type' => 'mcp_tool_result', 'tool_use_id' => 'mcptoolu_1', 'is_error' => false, 'content' => 'hi'],
            ['type' => 'code_execution_tool_result', 'tool_use_id' => 'srvtoolu_2', 'content' => $codeExecutionResult],
        ];
        $events = self::blockStreamEvents($content);
        // The request sends the blocks of an earlier turn back.
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello'], ['role' => 'assistant', 'content' => $content], ['role' => 'user', 'content' => 'Go on']], 'model' => 'claude-test'];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => $content]));
        $client->beta->messages->create(...$params);
        $this->transporter->addResponse(self::sse($events));
        foreach ($client->beta->messages->createStream(...$params) as $event);

        // A field whose name starts with `encrypted_` is left out. A content that is one object keeps its fields.
        $parts = [
            ['type' => 'tool_call', 'id' => 'srvtoolu_1', 'name' => 'web_search', 'arguments' => ['query' => 'x']],
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_1', 'response' => [['type' => 'web_search_result', 'url' => 'https://example.com', 'title' => 'Example', 'page_age' => '1 day']]],
            ['type' => 'tool_call', 'id' => 'mcptoolu_1', 'name' => 'echo', 'arguments' => ['text' => 'hi'], 'anthropic_mcp_server_name' => 'notes'],
            ['type' => 'tool_call_response', 'id' => 'mcptoolu_1', 'response' => [['type' => 'text', 'text' => 'hi']]],
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_2', 'response' => $codeExecutionResult],
        ];
        [$unary, $streamed] = $this->spans();
        $this->assertSame([['role' => 'assistant', 'parts' => $parts]], self::decode($unary->getAttributes()->get('gen_ai.output.messages')));
        // The streamed Message has the same fields, in the order of the SDK's models.
        $this->assertEquals([['role' => 'assistant', 'parts' => $parts]], self::decode($streamed->getAttributes()->get('gen_ai.output.messages')));
        foreach ([$unary, $streamed] as $span) {
            $this->assertSame(['role' => 'assistant', 'parts' => $parts], self::decode($span->getAttributes()->get('gen_ai.input.messages'))[1]);
            $this->assertStringNotContainsString('SEALED', json_encode($span->getAttributes()->toArray(), JSON_THROW_ON_ERROR));
        }
    }

    public function testOnlyAToolUseBlockWithAToolsetNameHasItOnItsToolCallPart(): void
    {
        $toolUses = [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'screenshot', 'toolset_name' => 'computer', 'input' => ['x' => 1]],
            ['type' => 'tool_use', 'id' => 'toolu_2', 'name' => 'get_time', 'toolset_name' => null, 'input' => ['x' => 2]],
            ['type' => 'tool_use', 'id' => 'toolu_3', 'name' => 'get_weather', 'input' => ['x' => 3]],
        ];
        // Only the part of a `tool_use` block has a toolset name: not that of a server or an MCP tool use that carries one, nor that of a tool result.
        $others = [
            ['type' => 'server_tool_use', 'id' => 'srvtoolu_1', 'name' => 'web_search', 'toolset_name' => 'computer', 'input' => ['query' => 'x']],
            ['type' => 'mcp_tool_use', 'id' => 'mcptoolu_1', 'name' => 'echo', 'server_name' => 'notes', 'toolset_name' => 'computer', 'input' => ['text' => 'hi']],
            ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'toolset_name' => 'computer', 'content' => 'done'],
        ];
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello'], ['role' => 'assistant', 'content' => [...$toolUses, ...$others]], ['role' => 'user', 'content' => 'Go on']], 'model' => 'claude-test'];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        // Only the beta Messages API answers with an MCP tool use.
        foreach ([[$client->messages, 1], [$client->beta->messages, 2]] as [$messages, $count]) {
            $content = [...$toolUses, ...array_slice($others, 0, $count)];
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => $content]));
            $messages->create(...$params);
            $this->transporter->addResponse(self::sse(self::blockStreamEvents($content)));
            foreach ($messages->createStream(...$params) as $event);
        }

        // The toolset name follows the arguments. A toolset name that is null leaves the part as it is without one.
        $toolCalls = [
            ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'screenshot', 'arguments' => ['x' => 1], 'anthropic_toolset_name' => 'computer'],
            ['type' => 'tool_call', 'id' => 'toolu_2', 'name' => 'get_time', 'arguments' => ['x' => 2]],
            ['type' => 'tool_call', 'id' => 'toolu_3', 'name' => 'get_weather', 'arguments' => ['x' => 3]],
        ];
        $otherParts = [
            ['type' => 'tool_call', 'id' => 'srvtoolu_1', 'name' => 'web_search', 'arguments' => ['query' => 'x']],
            ['type' => 'tool_call', 'id' => 'mcptoolu_1', 'name' => 'echo', 'arguments' => ['text' => 'hi'], 'anthropic_mcp_server_name' => 'notes'],
            ['type' => 'tool_call_response', 'id' => 'toolu_1', 'response' => [['type' => 'text', 'text' => 'done']]],
        ];
        $spans = $this->spans();
        $this->assertCount(4, $spans);
        foreach ($spans as $index => $span) {
            $this->assertSame(['role' => 'assistant', 'parts' => [...$toolCalls, ...$otherParts]], self::decode($span->getAttributes()->get('gen_ai.input.messages'))[1]);
            $this->assertSame([['role' => 'assistant', 'parts' => [...$toolCalls, ...array_slice($otherParts, 0, $index < 2 ? 1 : 2)]]], self::decode($span->getAttributes()->get('gen_ai.output.messages')));
        }
    }

    public function testResultBlockContentIsAListOfContentBlocksOrOneObject(): void
    {
        $error = ['type' => 'web_search_tool_result_error', 'error_code' => 'max_uses_exceeded'];
        $this->transporter->addResponse(self::json(self::MESSAGE));

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->beta->messages->create(maxTokens: 16, messages: [['role' => 'assistant', 'content' => [
            ['type' => 'web_search_tool_result', 'tool_use_id' => 'srvtoolu_1', 'content' => $error],
            ['type' => 'mcp_tool_result', 'tool_use_id' => 'mcptoolu_1', 'is_error' => false, 'content' => [['type' => 'text', 'text' => 'hi'], ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => 'image/png', 'data' => 'AAAA']]]],
            ['type' => 'text_editor_code_execution_tool_result', 'tool_use_id' => 'srvtoolu_2', 'content' => ['type' => 'text_editor_code_execution_view_result', 'file_type' => 'image', 'content' => 'AAAA', 'num_lines' => 1]],
            ['type' => 'web_fetch_tool_result', 'tool_use_id' => 'srvtoolu_3', 'content' => ['type' => 'web_fetch_result', 'url' => 'https://example.com', 'content' => ['type' => 'document', 'source' => ['type' => 'base64', 'media_type' => 'application/pdf', 'data' => 'AAAA'], 'title' => 'Example']]],
            ['type' => 'web_search_tool_result', 'tool_use_id' => 'srvtoolu_4'],
            // A search result block outside a tool result has no part of its own.
            ['type' => 'search_result', 'source' => 'https://example.com', 'title' => 'Example', 'content' => [['type' => 'text', 'text' => 'body']]],
        ]]], model: 'claude-test');

        // Image and document data is left out: a block keeps only its type, and the view of an image loses its content.
        $this->assertSame([['role' => 'assistant', 'parts' => [
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_1', 'response' => $error],
            ['type' => 'tool_call_response', 'id' => 'mcptoolu_1', 'response' => [['type' => 'text', 'text' => 'hi'], ['type' => 'image']]],
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_2', 'response' => ['type' => 'text_editor_code_execution_view_result', 'file_type' => 'image', 'num_lines' => 1]],
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_3', 'response' => ['type' => 'web_fetch_result', 'url' => 'https://example.com', 'content' => ['type' => 'document']]],
            ['type' => 'tool_call_response', 'id' => 'srvtoolu_4', 'response' => []],
            ['type' => 'anthropic_search_result'],
        ]]], self::decode($this->onlySpan()->getAttributes()->get('gen_ai.input.messages')));
    }

    public function testToolResultOverTheLimitIsRemovedWholeAndItsMessageStays(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $big = str_repeat('y', Content::LIMIT);
        $messages = [
            ['role' => 'user', 'content' => [['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => [['type' => 'search_result', 'source' => 'https://example.com', 'title' => 'Example', 'content' => [['type' => 'text', 'text' => $big]]]]]]],
            ['role' => 'user', 'content' => [['type' => 'tool_result', 'tool_use_id' => 'toolu_2', 'content' => 'found']]],
        ];

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');

        // The blocks of a tool result count toward the limit, and no block is shortened to fit.
        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame([['role' => 'user', 'parts' => []], ['role' => 'user', 'parts' => [['type' => 'tool_call_response', 'id' => 'toolu_2', 'response' => [['type' => 'text', 'text' => 'found']]]]]], self::decode($attributes['gen_ai.input.messages']));
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testResultThatIsOneObjectOverTheLimitIsRemovedWhole(): void
    {
        $big = ['type' => 'code_execution_tool_result', 'tool_use_id' => 'srvtoolu_1', 'content' => ['type' => 'code_execution_result', 'stdout' => str_repeat('z', Content::LIMIT), 'stderr' => '', 'return_code' => 0, 'content' => []]];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(maxTokens: 16, messages: [['role' => 'assistant', 'content' => [$big]], ['role' => 'user', 'content' => 'Go on']], model: 'claude-test');
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => [['type' => 'text', 'text' => 'Hi'], $big]]));
        $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        // The fields of the object count toward the limit, and none is shortened to fit.
        [$request, $response] = $this->spans();
        $this->assertSame([['role' => 'assistant', 'parts' => []], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Go on']]]], self::decode($request->getAttributes()->get('gen_ai.input.messages')));
        $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi there']]]], self::decode($request->getAttributes()->get('gen_ai.output.messages')));
        $this->assertTrue($request->getAttributes()->get('anthropic.content.truncated'));
        // The parts before it go first. It is then the one part left, and only a text part is cut.
        $this->assertSame('[{"role":"user","parts":[]}]', $response->getAttributes()->get('gen_ai.input.messages'));
        $this->assertSame('[{"role":"assistant","parts":[]}]', $response->getAttributes()->get('gen_ai.output.messages'));
        $this->assertTrue($response->getAttributes()->get('anthropic.content.truncated'));
    }

    public function testInputMessagesUnderTheLimitAreTheirPlainJson(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();
        $messages = [
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'héllo / 1.0']]],
            ['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => 1.0]]]],
        ];

        Content::setMessageContentAttributes($span, null, $messages, null);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame(json_encode($messages, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION), $attributes['gen_ai.input.messages']);
        $this->assertArrayNotHasKey('gen_ai.output.messages', $attributes);
        $this->assertArrayNotHasKey('anthropic.content.truncated', $attributes);
    }

    /**
     * The cases that every SDK shares. The limit is small so that each case can be read.
     *
     * @param MessageContent $content
     * @param MessageContent $expected
     */
    #[DataProvider('sizeBoundCases')]
    public function testContentOverTheLimitLosesMessagePartsFromTheStart(int $limit, array $content, array $expected, bool $truncated, int $size): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();

        Content::setMessageContentAttributes($span, $content['system'], $content['input'], $content['output'], $content['stopSequences'] ?? [], $limit);
        $span->end();

        $exported = $this->onlySpan();
        $attributes = $exported->getAttributes()->toArray();
        $flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        // An attribute that was absent stays absent, and an emptied list or a message without parts stays `[]`.
        foreach (['gen_ai.system_instructions' => $expected['system'], 'gen_ai.input.messages' => $expected['input'], 'gen_ai.output.messages' => $expected['output']] as $attribute => $value) {
            $this->assertSame(null === $value ? null : json_encode($value, $flags), $attributes[$attribute] ?? null, $attribute);
        }
        // The stop sequences are whole or absent: the expected ones are null when the input has none or loses them.
        $stopSequences = $expected['stopSequences'] ?? null;
        $this->assertSame($stopSequences, $attributes['gen_ai.request.stop_sequences'] ?? null);
        $this->assertSame($truncated ? true : null, $attributes['anthropic.content.truncated'] ?? null);
        $this->assertSame($size, self::contentSize($exported) + array_sum(array_map('strlen', $stopSequences ?? [])));
    }

    /**
     * @return iterable<string, array{int, MessageContent, MessageContent, bool, int}>
     */
    public static function sizeBoundCases(): iterable
    {
        // Nothing is over the bound, so nothing is removed and the span is not marked.
        yield 'under the bound is unchanged' => [
            1000,
            [
                'system' => [['type' => 'text', 'content' => 'Be brief.']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'hi']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'hello']]]],
            ],
            [
                'system' => [['type' => 'text', 'content' => 'Be brief.']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'hi']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'hello']]]],
            ],
            false,
            163,
        ];

        // A total equal to the bound is not over it.
        yield 'exactly at the bound is unchanged' => [
            163,
            [
                'system' => [['type' => 'text', 'content' => 'Be brief.']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'hi']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'hello']]]],
            ],
            [
                'system' => [['type' => 'text', 'content' => 'Be brief.']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'hi']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'hello']]]],
            ],
            false,
            163,
        ];

        // One byte over: the first system part goes whole, and everything after it stays.
        yield 'system parts go first' => [
            260,
            [
                'system' => [['type' => 'text', 'content' => 'S1-ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'], ['type' => 'text', 'content' => 'S2 stays']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'answer']]]],
            ],
            [
                'system' => [['type' => 'text', 'content' => 'S2 stays']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'answer']]]],
            ],
            true,
            169,
        ];

        // The emptied system list stays. The oldest input message loses both parts and stays without parts.
        yield 'input parts follow and a message is left without parts' => [
            222,
            [
                'system' => [['type' => 'text', 'content' => 'sys-ssssssssssssssssssssssssssssss']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'old-oooooooooooooooooooooooooooooooooooooooo'], ['type' => 'anthropic_image']]], ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'mid']]], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'last']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'answer']]]],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []], ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'mid']]], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'last']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'answer']]]],
            ],
            true,
            219,
        ];

        // A request without system instructions or output: the first message keeps its third part, and no attribute is created.
        yield 'parts not whole messages are removed and absent attributes stay absent' => [
            180,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'a-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'], ['type' => 'text', 'content' => 'b-bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'], ['type' => 'text', 'content' => 'c stays']]], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'newest']]]],
                'output' => null,
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'c stays']]], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'newest']]]],
                'output' => null,
            ],
            true,
            124,
        ];

        // Once the system and the input are emptied, the first output part goes. It is a reasoning part, which is never cut.
        yield 'output parts go from the start and reasoning goes whole' => [
            183,
            [
                'system' => [['type' => 'text', 'content' => 'sys']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question qqqqqqqqqqqqqqqqqqqq']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'reasoning', 'content' => 'think-tttttttttttttttttttttttttttttttttttttttttttttttttt'], ['type' => 'text', 'content' => 'final answer']]]],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'final answer']]]],
            ],
            true,
            103,
        ];

        // The tool call goes whole. The one part left is text, and it keeps the longest start that fits: the total is the bound.
        yield 'last remaining text part is cut from its end' => [
            126,
            [
                'system' => [['type' => 'text', 'content' => 'sys']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'get_weather', 'arguments' => ['city' => 'Paris']], ['type' => 'text', 'content' => '012345678901234567890123456789012345678901234567890123456789']]]],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => '01234567890123456789012345678901234']]]],
            ],
            true,
            126,
        ];

        // A quote or a newline is two bytes of JSON. The start that is kept does not end inside an escape.
        yield 'cut counts the serialized escapes' => [
            133,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => "say \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\n"]]]],
                'output' => null,
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => "say \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay \"hi\"\nsay "]]]],
                'output' => null,
            ],
            true,
            132,
        ];

        // The start that is kept ends between two characters, which are one to four bytes each.
        yield 'cut is at a character boundary' => [
            117,
            [
                'system' => null,
                'input' => null,
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'a€😀éa€😀éa€😀éa€😀éa€😀éa€😀é']]]],
            ],
            [
                'system' => null,
                'input' => null,
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'a€😀éa€😀éa€😀éa€😀éa€😀éa€']]]],
            ],
            true,
            115,
        ];

        // The one part left is a tool call, which is never cut, so it goes whole and its message stays without parts.
        yield 'last remaining part that is not text is removed whole' => [
            120,
            [
                'system' => [['type' => 'text', 'content' => 'sys']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'write_file', 'arguments' => ['path' => 'a.txt', 'text' => 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww']]]]],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => []]],
            ],
            true,
            63,
        ];

        // Only a text part is cut. A reasoning part that is the one part left goes whole.
        yield 'last remaining reasoning part is removed whole' => [
            110,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'q']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'reasoning', 'content' => 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr']]]],
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => []]],
            ],
            true,
            61,
        ];

        // The stop sequences exceed the bound by themselves, so they are left out whole and count as nothing. The parts are still over the bound, so every part goes.
        yield 'stop sequences alone over the bound are removed whole then parts' => [
            100,
            [
                'system' => [['type' => 'text', 'content' => 'sys']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'f', 'arguments' => []]]]],
                'stopSequences' => ['STOP-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => []]],
                'stopSequences' => null,
            ],
            true,
            63,
        ];

        // The stop sequences exceed the bound by themselves, so they are left out whole and the span is marked. What is left fits, so no part goes.
        yield 'stop sequences alone over the bound are removed whole' => [
            100,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => null,
                'stopSequences' => ['STOP-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => null,
                'stopSequences' => null,
            ],
            true,
            28,
        ];

        // Every part goes. The emptied list and the messages without parts stay in their attributes, so the span is exported over the bound.
        yield 'kept structure alone over a tiny bound is exported as it is' => [
            10,
            [
                'system' => [['type' => 'text', 'content' => 'sys']],
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]],
                'output' => [['role' => 'assistant', 'parts' => [['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'f', 'arguments' => []]]]],
            ],
            [
                'system' => [],
                'input' => [['role' => 'user', 'parts' => []]],
                'output' => [['role' => 'assistant', 'parts' => []]],
            ],
            true,
            63,
        ];

        // Each é is one character and two bytes. The values have 86 characters, under the bound, and 116 bytes, over it, so the text is cut: 22 of the 30 é fit, and the total is the bound.
        yield 'multibyte text is measured in utf8 bytes' => [
            100,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'éééééééééééééééééééééééééééééé']]]],
                'output' => null,
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'éééééééééééééééééééééé']]]],
                'output' => null,
            ],
            true,
            100,
        ];

        // 44 bytes of content fit. The first 42 end after the third €, and the 44th falls inside the 😀 that follows, which is four bytes. No part of that character stays, and the total is 2 bytes under the bound.
        yield 'cut lands on a whole character in multibyte text' => [
            100,
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'cost 5€ 😀 cost 5€ 😀 total: 10€😀 thanks, see you again next week! Bye for now.']]]],
                'output' => null,
            ],
            [
                'system' => null,
                'input' => [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'cost 5€ 😀 cost 5€ 😀 total: 10€']]]],
                'output' => null,
            ],
            true,
            98,
        ];
    }

    public function testLastTextPartWithNoRoomForAnyOfItsContentStaysWithEmptyContent(): void
    {
        $tracer = $this->tracerProvider->getTracer('test');

        // The message and its part exceed the limit by themselves, so not even an empty `content` fits.
        $span = $tracer->spanBuilder('chat')->startSpan();
        Content::setMessageContentAttributes($span, null, [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'question']]]], null, [], 10);
        $span->end();
        // A `content` that is empty already has nothing to lose.
        $span = $tracer->spanBuilder('chat')->startSpan();
        Content::setMessageContentAttributes($span, [['type' => 'text', 'content' => '']], null, null, [], 10);
        $span->end();

        [$cut, $empty] = $this->spans();
        $this->assertSame('[{"role":"user","parts":[{"type":"text","content":""}]}]', $cut->getAttributes()->get('gen_ai.input.messages'));
        $this->assertTrue($cut->getAttributes()->get('anthropic.content.truncated'));
        $this->assertSame('[{"type":"text","content":""}]', $empty->getAttributes()->get('gen_ai.system_instructions'));
        $this->assertNull($empty->getAttributes()->get('anthropic.content.truncated'));
    }

    public function testOutputMessagesLoseTheirPartsFromTheFirstMessageOn(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();
        $output = [
            ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => str_repeat('a', 50)]]],
            ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => str_repeat('b', 50)], ['type' => 'text', 'content' => 'end']]],
        ];

        Content::setMessageContentAttributes($span, null, [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], $output, [], 150);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('[{"role":"user","parts":[]}]', $attributes['gen_ai.input.messages']);
        $this->assertSame('[{"role":"assistant","parts":[]},{"role":"assistant","parts":[{"type":"text","content":"end"}]}]', $attributes['gen_ai.output.messages']);
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testInputMessageOverTheLimitByItselfStaysWithoutItsPart(): void
    {
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $huge = str_repeat('z', Content::LIMIT + 10);

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => $huge]], model: 'claude-test');

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        // The message stays in its attribute, without parts. The output fits, so it keeps its part.
        $this->assertSame('[{"role":"user","parts":[]}]', $attributes['gen_ai.input.messages']);
        $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi there']]]], self::decode($attributes['gen_ai.output.messages']));
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testSystemInstructionsOverTheLimitLoseTheirFirstPartsBeforeAnyMessageLosesOne(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();
        $system = [['type' => 'text', 'content' => str_repeat('s', Content::LIMIT + 10)], ['type' => 'text', 'content' => 'last']];
        $messages = [
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'first']]],
            ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'second']]],
            ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'third']]],
        ];
        $output = [['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'one'], ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => 'x']]]]];

        Content::setMessageContentAttributes($span, $system, $messages, $output);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        // The first system part goes whole, although it is text, because other parts are left. The rest fits.
        $this->assertSame([['type' => 'text', 'content' => 'last']], self::decode($attributes['gen_ai.system_instructions']));
        $this->assertSame($messages, self::decode($attributes['gen_ai.input.messages']));
        $this->assertSame($output, self::decode($attributes['gen_ai.output.messages']));
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testSystemInstructionsThatAreTheOnePartLeftAreCutFromTheirEnd(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();

        Content::setMessageContentAttributes($span, [['type' => 'text', 'content' => str_repeat('s', 100)]], [], null, [], 64);
        $span->end();

        $exported = $this->onlySpan();
        $attributes = $exported->getAttributes()->toArray();
        $instructions = self::textParts(self::decode($attributes['gen_ai.system_instructions']));
        $this->assertCount(1, $instructions);
        $this->assertMatchesRegularExpression('/\As+\z/', $instructions[0]['content']);
        $this->assertSame('[]', $attributes['gen_ai.input.messages']);
        $this->assertTrue($attributes['anthropic.content.truncated']);
        $this->assertSame(64, self::contentSize($exported));
    }

    public function testStopSequencesAreLeftOutWholeOnlyWhenTheyExceedTheLimitByThemselves(): void
    {
        $tracer = $this->tracerProvider->getTracer('test');
        $atTheLimit = [str_repeat('e', Content::LIMIT - 4), 'STOP'];
        $over = [str_repeat('e', Content::LIMIT - 3), 'STOP'];

        foreach ([$atTheLimit, $over] as $stopSequences) {
            $span = $tracer->spanBuilder('chat')->startSpan();
            Content::setMessageContentAttributes($span, [], [], [['role' => 'assistant', 'parts' => []]], $stopSequences);
            $span->end();
        }

        [$kept, $leftOut] = $this->spans();
        foreach ([$kept, $leftOut] as $exported) {
            // The lists have no part to lose, so they stay as they are. No input messages are an empty list.
            $this->assertSame('[]', $exported->getAttributes()->get('gen_ai.system_instructions'));
            $this->assertSame('[]', $exported->getAttributes()->get('gen_ai.input.messages'));
            $this->assertSame('[{"role":"assistant","parts":[]}]', $exported->getAttributes()->get('gen_ai.output.messages'));
        }
        // Strings that fill the limit are not over it. The lists then leave the span over the limit, and it is not marked.
        $this->assertSame($atTheLimit, $kept->getAttributes()->get('gen_ai.request.stop_sequences'));
        $this->assertNull($kept->getAttributes()->get('anthropic.content.truncated'));
        // One more byte, and the attribute is left out whole.
        $this->assertArrayNotHasKey('gen_ai.request.stop_sequences', $leftOut->getAttributes()->toArray());
        $this->assertTrue($leftOut->getAttributes()->get('anthropic.content.truncated'));
    }

    public function testStopSequencesOverTheLimitByThemselvesCountAsNothingForTheOtherContent(): void
    {
        $tracer = $this->tracerProvider->getTracer('test');
        $stopSequences = ['STOP-'.str_repeat('x', 100)];
        $system = [['type' => 'text', 'content' => 'Be brief.']];
        $messages = [['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]];

        // The other content fits the limit without the stop sequences.
        $span = $tracer->spanBuilder('chat')->startSpan();
        Content::setMessageContentAttributes($span, $system, $messages, null, $stopSequences, 100);
        $span->end();
        // It does not here, so the system instructions lose their part as well.
        $span = $tracer->spanBuilder('chat')->startSpan();
        Content::setMessageContentAttributes($span, $system, $messages, null, $stopSequences, 70);
        $span->end();

        [$whole, $reduced] = $this->spans();
        foreach ([$whole, $reduced] as $exported) {
            $this->assertArrayNotHasKey('gen_ai.request.stop_sequences', $exported->getAttributes()->toArray());
            $this->assertSame($messages, self::decode($exported->getAttributes()->get('gen_ai.input.messages')));
            $this->assertTrue($exported->getAttributes()->get('anthropic.content.truncated'));
        }
        $this->assertSame($system, self::decode($whole->getAttributes()->get('gen_ai.system_instructions')));
        $this->assertSame(100, self::contentSize($whole));
        $this->assertSame('[]', $reduced->getAttributes()->get('gen_ai.system_instructions'));
        $this->assertSame(63, self::contentSize($reduced));
    }

    public function testStopSequencesOverTheBoundAreLeftOutWhenTheRequestIsRecordedAndWhenTheResponseIs(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content', 'maxContentBytes' => 256]]);
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test', 'stopSequences' => [str_repeat('e', 253), 'STOP']];

        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(...$params);
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        foreach ($client->messages->createStream(...$params) as $event);
        // A stream that is closed before it is read has only what the request recorded.
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        $client->messages->createStream(...$params)->close();

        $spans = $this->spans();
        $this->assertCount(3, $spans);
        foreach ($spans as $span) {
            $attributes = $span->getAttributes()->toArray();
            $this->assertArrayNotHasKey('gen_ai.request.stop_sequences', $attributes);
            $this->assertSame([['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($attributes['gen_ai.input.messages']));
            $this->assertTrue($attributes['anthropic.content.truncated']);
        }
        $this->assertArrayNotHasKey('gen_ai.output.messages', $spans[2]->getAttributes()->toArray());
    }

    public function testContentOverTheLimitLosesTheSystemInstructionsThenTheInputThenTheFirstOutputParts(): void
    {
        // The parts of the response exceed 0.75 MB together, and they fit without the first.
        $content = [
            ['type' => 'text', 'text' => str_repeat('a', 400_000)],
            ['type' => 'text', 'text' => str_repeat('b', 300_000)],
            ['type' => 'text', 'text' => str_repeat('c', 300_000)],
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => ['q' => 'x']],
        ];
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => $content]));
        $this->transporter->addResponse(self::sse([
            ['type' => 'message_start', 'message' => [...self::MESSAGE, 'content' => [], 'stop_reason' => null]],
            ...array_merge(...array_map(static fn (int $index): array => [
                ['type' => 'content_block_start', 'index' => $index, 'content_block' => ['type' => 'text', 'text' => '']],
                ['type' => 'content_block_delta', 'index' => $index, 'delta' => ['type' => 'text_delta', 'text' => $content[$index]['text']]],
                ['type' => 'content_block_stop', 'index' => $index],
            ], [0, 1, 2])),
            ['type' => 'content_block_start', 'index' => 3, 'content_block' => ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => new \stdClass]],
            ['type' => 'content_block_delta', 'index' => 3, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"q":"x"}']],
            ['type' => 'content_block_stop', 'index' => 3],
            ['type' => 'message_delta', 'delta' => ['stop_reason' => 'tool_use', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]],
            ['type' => 'message_stop'],
        ]));
        $messages = [['role' => 'user', 'content' => 'first'], ['role' => 'assistant', 'content' => 'second'], ['role' => 'user', 'content' => 'third']];
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $client->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test', system: 'Be brief.');
        foreach ($client->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test', system: 'Be brief.') as $event);

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $attributes = $span->getAttributes()->toArray();
            // The system instructions lose their part first, then every input message does. The emptied list and the messages stay.
            $this->assertSame('[]', $attributes['gen_ai.system_instructions']);
            $this->assertSame('[{"role":"user","parts":[]},{"role":"assistant","parts":[]},{"role":"user","parts":[]}]', $attributes['gen_ai.input.messages']);
            // Then the output loses its first part, whole, and the newest parts stay as they are.
            $this->assertSame([['role' => 'assistant', 'parts' => [
                ['type' => 'text', 'content' => $content[1]['text']],
                ['type' => 'text', 'content' => $content[2]['text']],
                ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => 'x']],
            ]]], self::decode($attributes['gen_ai.output.messages']));
            $this->assertTrue($attributes['anthropic.content.truncated']);
        }
    }

    public function testOneOutputPartOverTheLimitKeepsItsStart(): void
    {
        $huge = str_repeat('z', Content::LIMIT + 10);
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => [['type' => 'text', 'text' => $huge]]]));

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        $span = $this->onlySpan();
        $attributes = $span->getAttributes()->toArray();
        // The input message loses its part before the last part is cut. Both attributes stay, a list and not an object.
        $this->assertSame('[{"role":"user","parts":[]}]', $attributes['gen_ai.input.messages']);
        $parts = self::outputParts($attributes['gen_ai.output.messages']);
        $this->assertCount(1, $parts);
        $this->assertSame('text', $parts[0]['type']);
        $this->assertMatchesRegularExpression('/\Az+\z/', $parts[0]['content']);
        $this->assertTrue($attributes['anthropic.content.truncated']);
        // A client that sets no bound has the SDK's own, 0.75 MB.
        $this->assertSame(750_000, self::contentSize($span));
    }

    public function testLastReasoningPartOverTheLimitIsRemovedWhole(): void
    {
        $content = [['type' => 'text', 'text' => 'Hi'], ['type' => 'thinking', 'thinking' => str_repeat('t', Content::LIMIT + 10), 'signature' => 'sig']];
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => $content]));

        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        // Every part before it goes first. Only a text part is cut, so the reasoning part goes too, and its message stays.
        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('[{"role":"user","parts":[]}]', $attributes['gen_ai.input.messages']);
        $this->assertSame('[{"role":"assistant","parts":[]}]', $attributes['gen_ai.output.messages']);
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testPartThatIsNotTextGoesWholeAndThePartsAfterItStay(): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('chat')->startSpan();
        $call = ['type' => 'tool_call', 'id' => 'toolu_1', 'name' => 'lookup', 'arguments' => ['q' => str_repeat('x', Content::LIMIT)]];
        $parts = [['type' => 'text', 'content' => 'one'], $call, ['type' => 'text', 'content' => 'two']];

        Content::setMessageContentAttributes($span, null, [], [['role' => 'assistant', 'parts' => $parts]]);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertSame('[{"role":"assistant","parts":[{"type":"text","content":"two"}]}]', $attributes['gen_ai.output.messages']);
        $this->assertTrue($attributes['anthropic.content.truncated']);
    }

    public function testCutTextIsTheLongestStartOfWholeCharactersWhoseJsonFits(): void
    {
        $tracer = $this->tracerProvider->getTracer('test');
        $flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        $message = static fn (string $text): array => ['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => $text]]];
        // The last one has backslashes before a `u`, which are not the escape of a control character.
        foreach (['日本語🙂é', "a\n\"\\\x01\u{2028}🙂", "\\\\u00\x01é\\"] as $unit) {
            $text = str_repeat($unit, 12);
            $whole = strlen(json_encode([$message($text)], $flags));
            $empty = strlen(json_encode([$message('')], $flags));
            for ($room = $empty; $room < $whole; ++$room) {
                $span = $tracer->spanBuilder('chat')->startSpan();
                Content::setMessageContentAttributes($span, null, null, [$message($text)], [], $room);
                $span->end();

                $exported = $this->onlySpan();
                $this->exporter->getStorage()->exchangeArray([]);
                $this->assertTrue($exported->getAttributes()->get('anthropic.content.truncated'));
                // The part stays, also when none of its text fits.
                $parts = self::outputParts($exported->getAttributes()->get('gen_ai.output.messages'));
                $this->assertCount(1, $parts);
                $cut = $parts[0]['content'];
                $this->assertTrue(mb_check_encoding($cut, 'UTF-8'));
                $this->assertSame($cut, substr($text, 0, strlen($cut)));
                $this->assertLessThanOrEqual($room, self::contentSize($exported));
                // One more character does not fit.
                $longer = mb_substr($text, 0, mb_strlen($cut) + 1);
                $this->assertGreaterThan($room, strlen(json_encode([$message($longer)], $flags)));
            }
        }
    }

    public function testConversationIdComesFromTheRequestOption(): void
    {
        $this->transporter->addResponse(self::json(['input_tokens' => 12]));

        $this->client()->messages->countTokens(messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', requestOptions: ['openTelemetry' => ['conversationId' => 'conv_1']]);

        $span = $this->onlySpan();
        $this->assertSame('anthropic.messages.count_tokens', $span->getName());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('conv_1', $attributes['gen_ai.conversation.id']);
        $this->assertSame(12, $attributes['anthropic.message.count_tokens.input_tokens']);
        $this->assertArrayNotHasKey('gen_ai.operation.name', $attributes);
        $body = (string) $this->lastRequest()->getBody();
        $this->assertStringNotContainsString('conv_1', $body);
    }

    public function testConversationIdOfTheClientRequestOptionsReachesEveryCallSpanUnlessTheRequestNamesOne(): void
    {
        $client = new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test:8443',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0, 'openTelemetry' => ['conversationId' => 'conv_client']],
            openTelemetry: ['tracerProvider' => $this->tracerProvider],
        );
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $ofTheRequest = ['openTelemetry' => ['conversationId' => 'conv_request']];

        // The Messages methods start their own spans, before the client merges its options with the request's.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test');
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        foreach ($client->beta->messages->createStream(maxTokens: 16, messages: $messages, model: 'claude-test') as $event);
        $this->transporter->addResponse(self::json(['input_tokens' => 12]));
        $client->messages->countTokens(messages: $messages, model: 'claude-test');
        $this->transporter->addResponse(self::json(['id' => 'claude-test', 'type' => 'model', 'display_name' => 'Claude Test', 'created_at' => '2026-01-01T00:00:00Z']));
        $client->models->retrieve('claude-test');
        // The ID of the request wins over the client's.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test', requestOptions: $ofTheRequest);
        $this->transporter->addResponse(self::json(['input_tokens' => 12]));
        $client->messages->countTokens(messages: $messages, model: 'claude-test', requestOptions: RequestOptions::with(openTelemetry: $ofTheRequest['openTelemetry']));

        $conversations = array_map(static fn (ImmutableSpan $span): array => [$span->getName(), $span->getAttributes()->get('gen_ai.conversation.id')], $this->spans());
        $this->assertSame([
            ['anthropic.messages.create', 'conv_client'],
            ['anthropic.messages.create', 'conv_client'],
            ['anthropic.messages.count_tokens', 'conv_client'],
            ['anthropic.models.retrieve', 'conv_client'],
            ['anthropic.messages.create', 'conv_request'],
            ['anthropic.messages.count_tokens', 'conv_request'],
        ], $conversations);
    }

    public function testOpenTelemetryRequestOptionReplacesTheOneOfTheClientWhole(): void
    {
        $client = new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test:8443',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0, 'openTelemetry' => ['conversationId' => 'conv_client']],
            openTelemetry: ['tracerProvider' => $this->tracerProvider],
        );
        $messages = [['role' => 'user', 'content' => 'Hello']];
        $model = ['id' => 'claude-test', 'type' => 'model', 'display_name' => 'Claude Test', 'created_at' => '2026-01-01T00:00:00Z'];

        // A request that leaves the option out keeps the one of the client.
        $this->transporter->addResponse(self::json($model));
        $client->models->retrieve('claude-test', requestOptions: ['maxRetries' => 1]);
        $this->transporter->addResponse(self::json($model));
        $client->models->retrieve('claude-test', requestOptions: (new RequestOptions)->withMaxRetries(1));
        // A request that sets the option replaces the client's whole, even when it leaves the key out, or null.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $client->messages->create(maxTokens: 16, messages: $messages, model: 'claude-test', requestOptions: ['openTelemetry' => []]);
        $this->transporter->addResponse(self::json(['input_tokens' => 12]));
        $client->messages->countTokens(messages: $messages, model: 'claude-test', requestOptions: ['openTelemetry' => ['conversationId' => null]]);
        $this->transporter->addResponse(self::json($model));
        $client->models->retrieve('claude-test', requestOptions: (new RequestOptions)->withOpenTelemetry([]));
        $this->transporter->addResponse(self::json($model));
        $client->models->retrieve('claude-test', requestOptions: ['openTelemetry' => ['conversationId' => 'conv_request']]);

        $conversations = array_map(static fn (ImmutableSpan $span): array => [$span->getName(), $span->getAttributes()->get('gen_ai.conversation.id')], $this->spans());
        $this->assertSame([
            ['anthropic.models.retrieve', 'conv_client'],
            ['anthropic.models.retrieve', 'conv_client'],
            ['anthropic.messages.create', null],
            ['anthropic.messages.count_tokens', null],
            ['anthropic.models.retrieve', null],
            ['anthropic.models.retrieve', 'conv_request'],
        ], $conversations);

        // The last options that set the option win, and options that never set it still have none.
        $this->assertSame([], RequestOptions::parse(['openTelemetry' => ['conversationId' => 'conv_1']], ['openTelemetry' => []])->openTelemetry);
        $this->assertSame(['conversationId' => 'conv_1'], RequestOptions::parse(['openTelemetry' => ['conversationId' => 'conv_1']], ['maxRetries' => 0], new RequestOptions)->openTelemetry);
        $this->assertNull(RequestOptions::parse(['maxRetries' => 0], null, new RequestOptions)->openTelemetry ?? null);
    }

    /**
     * @param array<string, mixed>|null $option null for a client that is given no option
     * @param array<string, string> $environment
     */
    #[DataProvider('tracesSettingsThatEnableOrDisableTheSpans')]
    public function testTracesSettingEnablesOrDisablesTheSpans(?array $option, array $environment, bool $spans, bool $content): void
    {
        foreach ($environment as $name => $value) {
            putenv("{$name}={$value}");
        }
        $this->transporter->addResponse(self::json(self::MESSAGE));

        // @phpstan-ignore-next-line argument.type
        $client = is_null($option) ? $this->clientWithoutTheOption() : $this->client(['tracerProvider' => $this->tracerProvider, ...$option]);
        $message = $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        // The call is the same either way.
        $this->assertSame('msg_1', $message->id);
        if (!$spans) {
            $this->assertSame([], $this->spans());
            $this->assertSame('', $this->lastRequest()->getHeaderLine('traceparent'));

            return;
        }
        $this->assertNotSame('', $this->lastRequest()->getHeaderLine('traceparent'));
        $this->assertSame($content, null !== $this->onlySpan()->getAttributes()->get('gen_ai.input.messages'));
    }

    /**
     * @return iterable<string, array{array<string, mixed>|null, array<string, string>, bool, bool}>
     */
    public static function tracesSettingsThatEnableOrDisableTheSpans(): iterable
    {
        $off = ['ANTHROPIC_OPEN_TELEMETRY' => 'false'];
        $content = ['ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE' => 'content'];

        yield '`true` is short for enabled' => [['traces' => true], [], true, false];

        yield 'no option leaves the spans to their variable' => [null, $off, false, false];

        yield 'no option leaves the content mode to its variable' => [null, $content, true, true];

        yield 'a tracer provider alone is an option, so the variables do not apply' => [[], [...$off, ...$content], true, false];

        yield '`propagation` alone is an option, so the variables do not apply' => [['propagation' => true], [...$off, ...$content], true, false];

        yield '`true` is an option, so the variable does not apply' => [['traces' => true], $off, true, false];

        yield '`false` is short for not enabled' => [['traces' => false], [], false, false];

        yield 'a bool leaves the content mode at its default' => [['traces' => true], $content, true, false];

        yield '`enabled` alone' => [['traces' => ['enabled' => true]], $off, true, false];

        yield 'not enabled, whatever the other settings' => [['traces' => ['enabled' => false, 'contentMode' => 'content', 'maxContentBytes' => 64]], $content, false, false];

        yield 'an array without `enabled` leaves it at its default' => [['traces' => ['contentMode' => 'content']], $off, true, true];

        yield 'an array without `contentMode` leaves it at its default' => [['traces' => ['enabled' => true]], $content, true, false];

        yield 'an empty array sets nothing' => [['traces' => []], [], true, false];

        yield 'the content mode in code wins over its variable' => [['traces' => ['contentMode' => 'metadata_only']], $content, true, false];

        yield 'a variable named without `TRACES` is not read' => [null, ['ANTHROPIC_OPEN_TELEMETRY_CONTENT_MODE' => 'content'], true, false];

        yield 'nor is it beside the one that is' => [null, ['ANTHROPIC_OPEN_TELEMETRY_CONTENT_MODE' => 'content', 'ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE' => 'metadata_only'], true, false];
    }

    /**
     * @param array<string, mixed>|false $option
     */
    #[DataProvider('clientOptionsOfEveryKind')]
    public function testClientThatIsGivenAnyOptionReadsNoneOfTheVariables(array|false $option, bool $spans, bool $content): void
    {
        // Each variable says the opposite of its default.
        putenv('ANTHROPIC_OPEN_TELEMETRY=false');
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION=false');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=content');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES=1');
        // An option that names no tracer provider has the registered one.
        $this->registerTracerProvider();
        $this->transporter->addResponse(self::json(self::MESSAGE));

        // @phpstan-ignore-next-line argument.type
        $this->client($option)->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');

        if (!$spans) {
            $this->assertSame([], $this->spans());
            $this->assertFalse($this->lastRequest()->hasHeader('traceparent'));

            return;
        }
        // What the option leaves unset has its default: spans, the trace context, no content, and the SDK's own bound.
        $span = $this->onlySpan();
        $this->assertTrue($this->lastRequest()->hasHeader('traceparent'));
        $this->assertSame($content, null !== $span->getAttributes()->get('gen_ai.input.messages'));
        $this->assertNull($span->getAttributes()->get('anthropic.content.truncated'));
    }

    /**
     * @return iterable<string, array{array<string, mixed>|false, bool, bool}>
     */
    public static function clientOptionsOfEveryKind(): iterable
    {
        yield 'an empty option' => [[], true, false];

        yield '`false`' => [false, false, false];

        yield '`propagation` alone' => [['propagation' => true], true, false];

        yield '`traces` set to `true`' => [['traces' => true], true, false];

        yield 'an empty `traces`' => [['traces' => []], true, false];

        yield 'keys that are null' => [['tracerProvider' => null, 'propagation' => null, 'traces' => null], true, false];

        yield 'keys of `traces` that are null' => [['traces' => ['enabled' => null, 'contentMode' => null, 'maxContentBytes' => null]], true, false];

        yield 'the content mode alone, which leaves the bound at its default' => [['traces' => ['contentMode' => 'content']], true, true];

        yield 'a bound that is null is the default' => [['traces' => ['contentMode' => 'content', 'maxContentBytes' => null]], true, true];
    }

    public function testClientThatIsGivenNoOptionReadsAllFourVariables(): void
    {
        putenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION=false');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=content');
        putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES=1');
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->transporter->addResponse(self::json(self::MESSAGE));

        $this->clientWithoutTheOption()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $this->assertFalse($this->lastRequest()->hasHeader('traceparent'));
        $this->assertTrue($this->onlySpan()->getAttributes()->get('anthropic.content.truncated'));

        putenv('ANTHROPIC_OPEN_TELEMETRY=false');
        $this->clientWithoutTheOption()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        $this->assertCount(1, $this->spans());
    }

    /**
     * @param array<string, mixed> $option
     */
    #[DataProvider('clientOptionsWithAValueTheyDoNotAccept')]
    public function testClientOptionValueThatTheOptionDoesNotAcceptIsRefused(array $option, string $setting, string $value): void
    {
        try {
            // @phpstan-ignore-next-line argument.type
            new Client(apiKey: 'test-api-key', requestOptions: ['transporter' => $this->transporter], openTelemetry: $option);
            $this->fail('expected the option to be refused');
        } catch (\InvalidArgumentException $e) {
            // The message names the setting, what it takes, and the value it got.
            $this->assertStringStartsWith("{$setting} of the `openTelemetry` client option must be ", $e->getMessage());
            $this->assertStringEndsWith(", got {$value}", $e->getMessage());
        }

        // A value is refused whether or not the spans are enabled, and a platform client refuses it too.
        try {
            // @phpstan-ignore-next-line argument.type
            Bedrock\Client::withApiKey('key', region: 'us-east-1', requestOptions: ['transporter' => $this->transporter], openTelemetry: $option);
            $this->fail('expected the option to be refused');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringStartsWith("{$setting} of the `openTelemetry` client option must be ", $e->getMessage());
        }
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, string}>
     */
    public static function clientOptionsWithAValueTheyDoNotAccept(): iterable
    {
        yield 'no bytes' => [['traces' => ['maxContentBytes' => 0]], "['traces']['maxContentBytes']", '0'];

        yield 'fewer than no bytes' => [['traces' => ['maxContentBytes' => -1]], "['traces']['maxContentBytes']", '-1'];

        yield 'a part of a byte' => [['traces' => ['maxContentBytes' => 1.5]], "['traces']['maxContentBytes']", '1.5'];

        yield 'bytes as a string' => [['traces' => ['maxContentBytes' => '1024']], "['traces']['maxContentBytes']", "'1024'"];

        yield 'bytes as a bool' => [['traces' => ['maxContentBytes' => true]], "['traces']['maxContentBytes']", 'true'];

        yield 'bytes of spans that are not enabled' => [['traces' => ['enabled' => false, 'maxContentBytes' => 0]], "['traces']['maxContentBytes']", '0'];

        yield 'an unknown content mode' => [['traces' => ['contentMode' => 'everything']], "['traces']['contentMode']", "'everything'"];

        yield 'a content mode in the wrong case' => [['traces' => ['contentMode' => 'Content']], "['traces']['contentMode']", "'Content'"];

        yield '`enabled` as a string' => [['traces' => ['enabled' => 'false']], "['traces']['enabled']", "'false'"];

        yield '`traces` as a string' => [['traces' => 'content'], "['traces']", 'string'];

        yield 'a tracer provider that is none' => [['tracerProvider' => 'global'], "['tracerProvider']", 'string'];

        yield '`propagation` as a string' => [['propagation' => 'false'], "['propagation']", "'false'"];

        yield '`propagation` of spans that are not enabled' => [['traces' => false, 'propagation' => 0], "['propagation']", '0'];
    }

    /**
     * @param array<string, mixed>|null $traces the `traces` of the client's option beside the content mode, or null for a client that is given no option and has the content mode from its variable
     * @param array<string, string> $environment
     */
    #[DataProvider('contentBounds')]
    public function testContentIsCutAtTheBoundThatMaxContentBytesSets(?array $traces, array $environment, ?int $offset): void
    {
        $text = str_repeat('x', 300);
        $messages = [
            ['role' => 'user', 'content' => "1{$text}"],
            ['role' => 'assistant', 'content' => "2{$text}"],
            ['role' => 'user', 'content' => "3{$text}"],
        ];
        // What the content measures without a bound of its own: far below the SDK's.
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])->messages->create(maxTokens: 16, system: 'Be brief.', messages: $messages, model: 'claude-test');
        $whole = $this->onlySpan();
        $size = self::contentSize($whole);
        $this->assertNull($whole->getAttributes()->get('anthropic.content.truncated'));
        $this->assertGreaterThan(900, $size);

        // `$offset` is where the bound is, counted from that size, or null for no bound but the SDK's.
        foreach ($environment as $name => $value) {
            putenv("{$name}=".(null === $offset ? $value : str_replace('{bound}', (string) ($size + $offset), $value)));
        }
        if (array_key_exists('maxContentBytes', $traces ?? [])) {
            $traces['maxContentBytes'] = $size + (int) $offset;
        }
        $this->transporter->addResponse(self::json(self::MESSAGE));
        if (is_null($traces)) {
            putenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE=content');
        }
        // @phpstan-ignore-next-line argument.type
        $client = is_null($traces) ? $this->clientWithoutTheOption() : $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content', ...$traces]]);
        $client->messages->create(maxTokens: 16, system: 'Be brief.', messages: $messages, model: 'claude-test');

        $span = $this->spans()[1];
        if (null === $offset || $offset >= 0) {
            // The content fits the bound exactly, or has none but the SDK's: it is whole.
            $this->assertSame($size, self::contentSize($span));
            $this->assertNull($span->getAttributes()->get('anthropic.content.truncated'));

            return;
        }
        // One byte over the bound: the system instructions go first, as they do at the SDK's own bound.
        $this->assertTrue($span->getAttributes()->get('anthropic.content.truncated'));
        $this->assertLessThanOrEqual($size + $offset, self::contentSize($span));
        $this->assertSame('[]', $span->getAttributes()->get('gen_ai.system_instructions'));
        $this->assertSame($whole->getAttributes()->get('gen_ai.input.messages'), $span->getAttributes()->get('gen_ai.input.messages'));
        $this->assertSame($whole->getAttributes()->get('gen_ai.output.messages'), $span->getAttributes()->get('gen_ai.output.messages'));
    }

    /**
     * @return iterable<string, array{array<string, mixed>|null, array<string, string>, int|null}>
     */
    public static function contentBounds(): iterable
    {
        $variable = 'ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES';

        yield 'the option, one byte short' => [['maxContentBytes' => null], [], -1];

        yield 'the option, exactly the size' => [['maxContentBytes' => null], [], 0];

        yield 'the variable, one byte short' => [null, [$variable => '{bound}'], -1];

        yield 'the variable, exactly the size' => [null, [$variable => '{bound}'], 0];

        yield 'the variable does not apply beside `traces` settings that leave the bound out' => [['enabled' => true], [$variable => '1'], null];

        yield 'the option wins over the variable' => [['maxContentBytes' => null], [$variable => '1'], 0];

        yield 'a variable that is no number is ignored' => [null, [$variable => 'small'], null];

        yield 'a variable that is no whole number is ignored' => [null, [$variable => '1.5'], null];

        yield 'a variable of no bytes is ignored' => [null, [$variable => '0'], null];

        yield 'a variable of fewer than no bytes is ignored' => [null, [$variable => '-64'], null];

        yield 'an empty variable is ignored' => [null, [$variable => ''], null];

        yield 'a variable with leading zeros and spaces is the number it reads as' => [null, [$variable => ' 000{bound} '], -1];

        yield 'a variable of only zeros is ignored' => [null, [$variable => '000'], null];
    }

    public function testMaxContentBytesBoundsAStreamedMessageAndAToolRun(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content', 'maxContentBytes' => 256]]);

        // The request's content alone is over the bound, before the stream is read, and so is it with the response's.
        $this->transporter->addResponse(self::sse(self::streamEvents()));
        foreach ($client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => str_repeat('x', 300)], ['role' => 'user', 'content' => 'Hello']], model: 'claude-test') as $event);
        $streamed = $this->onlySpan();
        $this->assertTrue($streamed->getAttributes()->get('anthropic.content.truncated'));
        $this->assertLessThanOrEqual(256, self::contentSize($streamed));
        $this->assertSame([['role' => 'user', 'parts' => []], ['role' => 'user', 'parts' => [['type' => 'text', 'content' => 'Hello']]]], self::decode($streamed->getAttributes()->get('gen_ai.input.messages')));
        $this->assertSame([['role' => 'assistant', 'parts' => [['type' => 'text', 'content' => 'Hi']]]], self::decode($streamed->getAttributes()->get('gen_ai.output.messages')));

        // A tool's result loses its last blocks at the same bound.
        $blocks = [['type' => 'text', 'text' => 'first'], ['type' => 'text', 'text' => str_repeat('z', 300)], ['type' => 'text', 'text' => 'last']];
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => 'x'], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => $blocks]);
        $tool = $this->spans()[1];
        $this->assertSame(array_slice($blocks, 0, 1), self::decode($tool->getAttributes()->get('anthropic.tool_result.content')));
        $this->assertTrue($tool->getAttributes()->get('anthropic.content.truncated'));
    }

    public function testCallToASessionThreadIsInTheConversationOfTheThreadUnlessTheApplicationNamesOne(): void
    {
        $thread = ['id' => 'sthr_1', 'type' => 'session_thread'];
        $client = $this->client();

        $this->transporter->addResponse(self::json($thread));
        $client->beta->sessions->threads->retrieve('sthr_1', sessionID: 'sesn_1');
        $this->transporter->addResponse(self::json($thread));
        $client->beta->sessions->threads->archive('sthr_1', sessionID: 'sesn_1', requestOptions: ['openTelemetry' => ['conversationId' => 'conv_1']]);
        // A path without a thread names no conversation, and neither does the Session.
        $this->transporter->addResponse(self::json(self::SESSION));
        $client->beta->sessions->retrieve('sesn_1');

        [$ofTheThread, $ofTheApplication, $none] = array_map(static fn (ImmutableSpan $span): array => $span->getAttributes()->toArray(), $this->spans());
        $this->assertSame('sthr_1', $ofTheThread['anthropic.session.thread.id']);
        $this->assertSame('sthr_1', $ofTheThread['gen_ai.conversation.id']);
        $this->assertSame('sthr_1', $ofTheApplication['anthropic.session.thread.id']);
        $this->assertSame('conv_1', $ofTheApplication['gen_ai.conversation.id']);
        $this->assertSame('sesn_1', $none['anthropic.session.id']);
        $this->assertArrayNotHasKey('gen_ai.conversation.id', $none);
    }

    public function testInterleavedStreamsWithSharedOptionsGetTheirOwnSpans(): void
    {
        $this->transporter->addResponse(self::sse(self::streamEvents(id: 'msg_a')));
        $this->transporter->addResponse(self::sse(self::streamEvents(id: 'msg_b')));
        $options = RequestOptions::with(timeout: 30);
        $client = $this->client();

        $a = $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'a']], model: 'claude-test', requestOptions: $options)->getIterator();
        $b = $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'b']], model: 'claude-test', requestOptions: $options)->getIterator();
        $a->rewind();
        $b->rewind();
        while ($a->valid() || $b->valid()) {
            if ($a->valid()) {
                $a->next();
            }
            if ($b->valid()) {
                $b->next();
            }
        }

        $ids = [];
        foreach ($this->spans() as $span) {
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
            $ids[] = $span->getAttributes()->get('gen_ai.response.id');
        }
        sort($ids);
        $this->assertSame(['msg_a', 'msg_b'], $ids);
    }

    public function testLaterPageEmitsItsOwnSpan(): void
    {
        $batch = ['id' => 'msgbatch_1', 'type' => 'message_batch', 'processing_status' => 'ended', 'request_counts' => ['processing' => 0, 'succeeded' => 1, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];
        $this->transporter->addResponse(self::json(['data' => [$batch], 'has_more' => true, 'first_id' => 'msgbatch_1', 'last_id' => 'msgbatch_1']));
        $this->transporter->addResponse(self::json(['data' => [[...$batch, 'id' => 'msgbatch_2']], 'has_more' => false, 'first_id' => 'msgbatch_2', 'last_id' => 'msgbatch_2']));

        $page = $this->client()->messages->batches->list(limit: 1);
        $firstPage = $this->spans();
        $this->assertCount(1, $firstPage);
        $page->getNextPage();

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame('anthropic.messages.batches.list', $span->getName());
            $this->assertNull($span->getAttributes()->get('anthropic.message.batch.id'));
            // The request for a later page repeats the first one, so its span has the method and the route too.
            $this->assertSame('GET', $span->getAttributes()->get('http.request.method'));
            $this->assertSame('/v1/messages/batches', $span->getAttributes()->get('http.route'));
            $this->assertSame('/v1/messages/batches', $span->getAttributes()->get('url.path'));
        }
        $this->assertStringContainsString('after_id=msgbatch_1', (string) $this->lastRequest()->getUri());
        $this->assertSame('limit=1', $spans[0]->getAttributes()->get('url.query'));
        // The cursor that the page adds is a parameter the endpoint defines.
        $this->assertSame($this->lastRequest()->getUri()->getQuery(), $spans[1]->getAttributes()->get('url.query'));
        $this->assertStringContainsString('after_id=msgbatch_1', (string) $spans[1]->getAttributes()->get('url.query'));
    }

    public function testRequestTakesWhatItsSpanNeedsFromTheSdksOwnOptionsAndNotFromParameters(): void
    {
        // `request()` is public, for undocumented endpoints: tracing adds no parameter to it.
        $parameters = array_map(static fn (\ReflectionParameter $parameter): string => $parameter->getName(), (new \ReflectionMethod(Client::class, 'request'))->getParameters());
        $this->assertSame(['method', 'path', 'query', 'headers', 'body', 'unwrap', 'convert', 'page', 'stream', 'options'], $parameters);

        // What an SDK method says of its call is no request option: an array of request options has no key for it.
        try {
            // @phpstan-ignore-next-line argument.type
            RequestOptions::parse(['apiCall' => new ApiCallInfo(name: 'anthropic.messages.create')]);
            $this->fail('expected the key to be refused');
        } catch (\Error $e) {
            $this->assertStringContainsString('apiCall', $e->getMessage());
        }

        // A request that the application makes itself names no SDK method, and has no span.
        $this->transporter->addResponse(self::json(['ok' => true]));
        $this->client()->request(method: 'get', path: '/undocumented/endpoint', query: ['dog' => 'woof'], options: ['extraHeaders' => ['x-custom' => '1']]);
        $this->assertSame('1', $this->lastRequest()->getHeaderLine('x-custom'));
        $this->assertSame([], $this->spans());

        // The options a middleware gets say which call the request is of. The span that the method started is not theirs to keep.
        $seen = [];
        $middleware = static function (RequestInterface $request, \Closure $next, ?RequestOptions $options = null) use (&$seen): ResponseInterface {
            $call = $options?->apiCall();
            $seen[] = [$call?->name, $call?->span];

            $response = $next($request);
            self::assertInstanceOf(ResponseInterface::class, $response);

            return $response;
        };
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $this->client()->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test', requestOptions: ['middleware' => [$middleware]]);
        $this->assertSame([['anthropic.messages.create', null]], $seen);
        $this->assertSame('anthropic.messages.create', $this->onlySpan()->getName());
    }

    public function testBatchSpanHasTheBatchId(): void
    {
        $batch = ['id' => 'msgbatch_1', 'type' => 'message_batch', 'processing_status' => 'ended', 'request_counts' => ['processing' => 0, 'succeeded' => 1, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];
        $this->transporter->addResponse(self::json($batch));

        $this->client()->messages->batches->retrieve('msgbatch_1');

        $span = $this->onlySpan();
        $this->assertSame('anthropic.messages.batches.retrieve', $span->getName());
        $this->assertSame('msgbatch_1', $span->getAttributes()->get('anthropic.message.batch.id'));
        $this->assertArrayNotHasKey('anthropic.message.batch.request_count', $span->getAttributes()->toArray());
        // The route has the parameter as the API names it, and the path has the ID.
        $this->assertSame('/v1/messages/batches/{message_batch_id}', $span->getAttributes()->get('http.route'));
        $this->assertSame('/v1/messages/batches/msgbatch_1', $span->getAttributes()->get('url.path'));
    }

    public function testBatchCreateSpanHasTheBatchIdOfTheResponse(): void
    {
        $batch = ['id' => 'msgbatch_9', 'type' => 'message_batch', 'processing_status' => 'in_progress', 'request_counts' => ['processing' => 1, 'succeeded' => 0, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];
        $this->transporter->addResponse(self::json($batch));
        $this->transporter->addResponse(self::json($batch));
        $requests = [['customID' => 'one', 'params' => ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test']]];

        $this->client()->messages->batches->create(requests: $requests);
        $this->client()->beta->messages->batches->create(requests: $requests);

        $spans = $this->spans();
        $this->assertCount(2, $spans);
        foreach ($spans as $span) {
            $this->assertSame('anthropic.messages.batches.create', $span->getName());
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
            $this->assertSame('msgbatch_9', $span->getAttributes()->get('anthropic.message.batch.id'));
            $this->assertSame(1, $span->getAttributes()->get('anthropic.message.batch.request_count'));
        }
    }

    public function testCreateSpanHasTheIdTheApiReturnedEvenWhenItIsEmpty(): void
    {
        $batch = ['id' => '', 'type' => 'message_batch', 'processing_status' => 'in_progress', 'request_counts' => ['processing' => 1, 'succeeded' => 0, 'errored' => 0, 'canceled' => 0, 'expired' => 0], 'created_at' => '2026-01-01T00:00:00Z', 'expires_at' => '2026-01-02T00:00:00Z', 'ended_at' => null, 'archived_at' => null, 'cancel_initiated_at' => null, 'results_url' => null];
        $this->transporter->addResponse(self::json($batch));

        $this->client()->messages->batches->create(requests: [['customID' => 'one', 'params' => ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test']]]);

        [$span] = $this->spans();
        $this->assertSame('', $span->getAttributes()->get('anthropic.message.batch.id'));
    }

    public function testBatchMethodsSetTheBatchIdTheyAreCalledWithEvenWhenTheCallFails(): void
    {
        $client = $this->client();
        $calls = [
            'anthropic.messages.batches.retrieve' => static fn () => $client->beta->messages->batches->retrieve('msgbatch/2'),
            'anthropic.messages.batches.cancel' => static fn () => $client->messages->batches->cancel('msgbatch/2'),
            'anthropic.messages.batches.delete' => static fn () => $client->beta->messages->batches->delete('msgbatch/2'),
            'anthropic.messages.batches.results' => static fn () => $client->messages->batches->resultsStream('msgbatch/2'),
        ];

        foreach ($calls as $call) {
            $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']], status: 429));

            try {
                $call();
                $this->fail('expected a RateLimitException');
            } catch (RateLimitException) {
            }
        }

        $spans = $this->spans();
        $this->assertSame(array_keys($calls), array_map(static fn (ImmutableSpan $span): string => $span->getName(), $spans));
        foreach ($spans as $span) {
            $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
            // The ID is the method's argument, not what the request path encodes it to.
            $this->assertSame('msgbatch/2', $span->getAttributes()->get('anthropic.message.batch.id'));
        }
    }

    public function testSessionCreateSpanHasTheAgentTheModelAndTheEnvironmentOfTheSession(): void
    {
        $agents = [
            'agent_1',
            ['id' => 'agent_1', 'type' => 'agent'],
            // The model is the Session's, not the one the request overrides the agent's with.
            BetaManagedAgentsAgentWithOverridesParams::with(id: 'agent_1', type: 'agent_with_overrides', model: ['id' => 'claude-override']),
        ];
        // The four attributes are no content: every content mode has them.
        foreach ([$this->client(), $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']])] as $client) {
            foreach ($agents as $agent) {
                $this->transporter->addResponse(self::json(self::SESSION));
                $client->beta->sessions->create(agent: $agent, environmentID: 'env_1');
            }
        }

        $spans = $this->spans();
        $this->assertCount(6, $spans);
        foreach ($spans as $span) {
            $this->assertSame('anthropic.sessions.create', $span->getName());
            $this->assertSame(StatusCode::STATUS_OK, $span->getStatus()->getCode());
            $attributes = $span->getAttributes()->toArray();
            $this->assertSame('sesn_1', $attributes['anthropic.session.id']);
            $this->assertSame('agent_1', $attributes['gen_ai.agent.id']);
            $this->assertSame('env_1', $attributes['anthropic.session.environment.id']);
            $this->assertSame('Researcher', $attributes['gen_ai.agent.name']);
            $this->assertSame('claude-test-20260101', $attributes['gen_ai.request.model']);
        }
    }

    public function testSessionCreateThatFailsKeepsTheAgentAndTheEnvironmentOfTheRequest(): void
    {
        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']], status: 429));

        try {
            $this->client()->beta->sessions->create(agent: ['id' => 'agent_1', 'type' => 'agent'], environmentID: 'env_1');
            $this->fail('expected a RateLimitException');
        } catch (RateLimitException) {
        }

        $span = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_ERROR, $span->getStatus()->getCode());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('agent_1', $attributes['gen_ai.agent.id']);
        $this->assertSame('env_1', $attributes['anthropic.session.environment.id']);
        $this->assertArrayNotHasKey('gen_ai.agent.name', $attributes);
        $this->assertArrayNotHasKey('gen_ai.request.model', $attributes);
        $this->assertArrayNotHasKey('anthropic.session.id', $attributes);
    }

    public function testOnlySessionCreateHasTheAgentTheModelAndTheEnvironmentOfTheSession(): void
    {
        $this->transporter->addResponse(self::json(self::SESSION));

        $this->client()->beta->sessions->retrieve('sesn_1');

        $span = $this->onlySpan();
        $this->assertSame('anthropic.sessions.retrieve', $span->getName());
        $attributes = $span->getAttributes()->toArray();
        $this->assertSame('sesn_1', $attributes['anthropic.session.id']);
        foreach (['gen_ai.agent.id', 'gen_ai.agent.name', 'gen_ai.request.model', 'anthropic.session.environment.id'] as $attribute) {
            $this->assertArrayNotHasKey($attribute, $attributes);
        }
    }

    public function testThirdPartyClientsNameTheirProvider(): void
    {
        $names = [];
        foreach ($this->platformClients() as $client) {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $spans = $this->spans();
            $span = $spans[count($spans) - 1];
            $this->assertSame('anthropic.messages.create', $span->getName());
            $names[] = $span->getAttributes()->get('gen_ai.provider.name');
        }
        $this->assertSame(['aws.bedrock', 'gcp.vertex_ai', 'anthropic', 'aws.bedrock', 'anthropic', 'anthropic'], $names);
    }

    public function testPlatformClientsHaveTheRouteOfTheApiThePathTheySendAndAScopeOfTheirOwn(): void
    {
        $expected = [
            'bedrock' => ['com.anthropic.sdk.php.bedrock', '/model/claude-test/invoke', 'https://bedrock-runtime.us-east-1.amazonaws.com/model/claude-test/invoke'],
            'vertex' => ['com.anthropic.sdk.php.vertex', '/v1/projects/project/locations/us-east5/publishers/anthropic/models/claude-test:rawPredict', 'https://us-east5-aiplatform.googleapis.com/v1/projects/project/locations/us-east5/publishers/anthropic/models/claude-test:rawPredict'],
            'foundry' => ['com.anthropic.sdk.php.foundry', '/anthropic/v1/messages', 'https://foundry.example.test/anthropic/v1/messages'],
            'mantle' => ['com.anthropic.sdk.php.bedrock', '/anthropic/v1/messages', 'https://bedrock-mantle.us-east-1.api.aws/anthropic/v1/messages'],
            'aws' => ['com.anthropic.sdk.php.aws', '/v1/messages', 'https://aws-external-anthropic.us-east-1.api.aws/v1/messages'],
            'googlecloud' => ['com.anthropic.sdk.php.googlecloud', '/v1/projects/project/locations/global/workspaces/workspace/invoke/v1/messages', 'https://claude.googleapis.com/v1/projects/project/locations/global/workspaces/workspace/invoke/v1/messages'],
        ];

        $recorded = [];
        foreach ($this->platformClients() as $name => $client) {
            $this->transporter->addResponse(self::json(self::MESSAGE));
            $client->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
            $spans = $this->spans();
            $span = $spans[count($spans) - 1];
            $attributes = $span->getAttributes()->toArray();
            // The path and the URL are the ones the platform's client sent. The route is the API's on every platform.
            $this->assertSame($this->lastRequest()->getUri()->getPath(), $attributes['url.path'], $name);
            $this->assertSame((string) $this->lastRequest()->getUri(), $attributes['url.full'], $name);
            $this->assertSame('/v1/messages', $attributes['http.route'], $name);
            $this->assertSame('POST', $attributes['http.request.method'], $name);
            // The platform's client ships with the SDK, so its scope has the SDK's version.
            $this->assertSame(VERSION, $span->getInstrumentationScope()->getVersion(), $name);
            $recorded[$name] = [$span->getInstrumentationScope()->getName(), $attributes['url.path'], $attributes['url.full']];
        }
        $this->assertSame($expected, $recorded);
    }

    public function testFoundryUserProfilesCallsHaveTheFoundryScope(): void
    {
        $this->transporter->addResponse(self::json(['id' => 'uprof_1', 'type' => 'user_profile']));
        $client = Foundry\Client::withCredentials(
            apiKey: 'key',
            baseUrl: 'https://foundry.example.test/anthropic',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
            openTelemetry: ['tracerProvider' => $this->tracerProvider],
        );

        $client->userProfiles->retrieve('uprof_1');

        $span = $this->onlySpan();
        $this->assertSame('com.anthropic.sdk.php.foundry', $span->getInstrumentationScope()->getName());
        $this->assertSame('https://foundry.example.test/anthropic/v1/user_profiles/uprof_1', $span->getAttributes()->get('url.full'));
    }

    /**
     * A tracer provider, and the propagator to register if any, whose part named `$where` throws: one of {@see self::telemetryThatThrows()}.
     *
     * @return array{TracerProviderInterface, TextMapPropagatorInterface|null}
     */
    private function telemetryThatThrowsAt(string $where): array
    {
        $failure = new \RuntimeException('telemetry failed');
        $processor = new class($where, $failure) implements SpanProcessorInterface {
            public function __construct(private string $where, private \RuntimeException $failure) {}

            public function onStart(ReadWriteSpanInterface $span, ContextInterface $parentContext): void
            {
                'processor on start' === $this->where && throw $this->failure;
            }

            public function onEnd(ReadableSpanInterface $span): void
            {
                'processor on end' === $this->where && throw $this->failure;
            }

            public function forceFlush(?CancellationInterface $cancellation = null): bool
            {
                return true;
            }

            public function shutdown(?CancellationInterface $cancellation = null): bool
            {
                return true;
            }
        };
        $sampler = $this->createStub(SamplerInterface::class);
        $sampler->method('shouldSample')->willThrowException($failure);
        $propagator = $this->createStub(TextMapPropagatorInterface::class);
        $propagator->method('fields')->willThrowException($failure);
        $propagator->method('inject')->willThrowException($failure);
        $throwingProvider = $this->createStub(TracerProviderInterface::class);
        $throwingProvider->method('getTracer')->willThrowException($failure);
        // A recording span that throws when it is given an attribute or a status.
        $span = $this->createStub(SpanInterface::class);
        $span->method('isRecording')->willReturn(true);
        foreach (['setAttribute', 'setAttributes', 'setStatus'] as $method) {
            $span->method($method)->willThrowException($failure);
        }
        $builder = $this->createStub(SpanBuilderInterface::class);
        $builder->method('setSpanKind')->willReturnSelf();
        $builder->method('setAttributes')->willReturnSelf();
        $builder->method('startSpan')->willReturn($span);
        $tracer = $this->createStub(TracerInterface::class);
        $tracer->method('spanBuilder')->willReturn($builder);
        $spanProvider = $this->createStub(TracerProviderInterface::class);
        $spanProvider->method('getTracer')->willReturn($tracer);

        return [
            match ($where) {
                'sampler' => new TracerProvider($processor, $sampler),
                'tracer provider' => $throwingProvider,
                'span' => $spanProvider,
                default => new TracerProvider($processor),
            },
            'propagator' === $where ? $propagator : null,
        ];
    }

    /**
     * A client of each platform, by the name of its namespace in lower case, or `mantle` for the second client of `Bedrock`.
     *
     * @return array<string, Aws\Client|Bedrock\Client|Foundry\Client|GoogleCloud\Client|MantleClient|Vertex\Client>
     */
    private function platformClients(): array
    {
        $option = ['tracerProvider' => $this->tracerProvider];
        $requestOptions = ['transporter' => $this->transporter, 'maxRetries' => 0];

        return [
            'bedrock' => Bedrock\Client::withApiKey('key', region: 'us-east-1', requestOptions: $requestOptions, openTelemetry: $option),
            'vertex' => Vertex\Client::withAccessToken('token', location: 'us-east5', projectId: 'project', requestOptions: $requestOptions, openTelemetry: $option),
            'foundry' => Foundry\Client::withCredentials(apiKey: 'key', baseUrl: 'https://foundry.example.test/anthropic', requestOptions: $requestOptions, openTelemetry: $option),
            'mantle' => new MantleClient(apiKey: 'key', awsRegion: 'us-east-1', requestOptions: $requestOptions, openTelemetry: $option),
            'aws' => new Aws\Client(apiKey: 'key', awsRegion: 'us-east-1', workspaceId: 'default', requestOptions: $requestOptions, openTelemetry: $option),
            'googlecloud' => new GoogleCloud\Client(project: 'project', workspaceId: 'workspace', tokenProvider: static fn (): string => 'token', requestOptions: $requestOptions, openTelemetry: $option),
        ];
    }

    public function testToolRunnerEmitsInternalSpansAroundItsCalls(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_1', 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
            ['type' => 'tool_use', 'id' => 'toolu_2', 'name' => 'explode', 'input' => new \stdClass],
        ]]));
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_2']));
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (array $input): string => 'Sunny in '.(is_string($input['city'] ?? null) ? $input['city'] : '?'));
        $explode = new BetaRunnableTool(['name' => 'explode', 'description' => 'Fails', 'input_schema' => ['type' => 'object', 'properties' => new \stdClass]], static fn (): string => throw new \RuntimeException('boom'));

        $runner = $this->client()->beta->messages->toolRunner(
            maxTokens: 16,
            messages: [['role' => 'user', 'content' => 'Weather in Paris?']],
            model: 'claude-test',
            tools: [$weather, $explode],
            extraParams: ['requestOptions' => ['openTelemetry' => ['conversationId' => 'conv_1']]],
        );
        $runner->runUntilDone();

        $byName = [];
        foreach ($this->spans() as $span) {
            $byName[$span->getName()][] = $span;
        }
        $this->assertCount(1, $byName['anthropic.messages.tool_runner']);
        $toolRunnerSpan = $byName['anthropic.messages.tool_runner'][0];
        $this->assertSame(SpanKind::KIND_INTERNAL, $toolRunnerSpan->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $toolRunnerSpan->getStatus()->getCode());
        $this->assertSame('invoke_agent', $toolRunnerSpan->getAttributes()->get('gen_ai.operation.name'));
        $this->assertSame('claude-test', $toolRunnerSpan->getAttributes()->get('gen_ai.request.model'));
        $this->assertSame('conv_1', $toolRunnerSpan->getAttributes()->get('gen_ai.conversation.id'));
        $this->assertNull($toolRunnerSpan->getAttributes()->get('gen_ai.output.type'));

        // The stop reason is on each request of the runner, and not on the tool runner span.
        $this->assertNull($toolRunnerSpan->getAttributes()->get('anthropic.message.stop_reason'));
        $this->assertNull($toolRunnerSpan->getAttributes()->get('gen_ai.response.finish_reasons'));

        $this->assertCount(2, $byName['anthropic.messages.create']);
        foreach ($byName['anthropic.messages.create'] as $call) {
            $this->assertSame($toolRunnerSpan->getSpanId(), $call->getParentSpanId());
            $this->assertSame('conv_1', $call->getAttributes()->get('gen_ai.conversation.id'));
        }
        $this->assertSame(['tool_use', 'end_turn'], array_map(static fn (ImmutableSpan $call): mixed => $call->getAttributes()->get('anthropic.message.stop_reason'), $byName['anthropic.messages.create']));

        $tool = $byName['anthropic.custom_tool_use get_weather'][0];
        $this->assertSame(SpanKind::KIND_INTERNAL, $tool->getKind());
        $this->assertSame($toolRunnerSpan->getSpanId(), $tool->getParentSpanId());
        $this->assertSame(StatusCode::STATUS_OK, $tool->getStatus()->getCode());
        $this->assertSame('execute_tool', $tool->getAttributes()->get('gen_ai.operation.name'));
        $this->assertSame('toolu_1', $tool->getAttributes()->get('gen_ai.tool.call.id'));
        $this->assertSame('function', $tool->getAttributes()->get('gen_ai.tool.type'));
        $this->assertSame('Weather', $tool->getAttributes()->get('gen_ai.tool.description'));
        $this->assertNull($tool->getAttributes()->get('gen_ai.tool.call.arguments'));
        $this->assertNull($tool->getAttributes()->get('anthropic.tool_result.content'));

        $failed = $byName['anthropic.custom_tool_use explode'][0];
        $this->assertSame(StatusCode::STATUS_ERROR, $failed->getStatus()->getCode());
        $this->assertSame('tool_error', $failed->getAttributes()->get('error.type'));
        // Every tool span has the conversation ID of the runner, and no Session: this is the Messages tool runner.
        foreach ([$tool, $failed] as $toolUseSpan) {
            $this->assertSame('conv_1', $toolUseSpan->getAttributes()->get('gen_ai.conversation.id'));
            $this->assertNull($toolUseSpan->getAttributes()->get('anthropic.session.id'));
            $this->assertNull($toolUseSpan->getAttributes()->get('anthropic.session.thread.id'));
        }

        // Only a request has a method, a route, a URL and a server: the tool runner span and the tool spans have none.
        foreach ([$toolRunnerSpan, $tool, $failed] as $helperSpan) {
            $this->assertSame([], array_filter(array_keys($helperSpan->getAttributes()->toArray()), static fn (int|string $name): bool => 1 === preg_match('/^(http|url|server|network)\./', (string) $name)), $helperSpan->getName());
        }
        foreach ($byName['anthropic.messages.create'] as $call) {
            $this->assertSame('POST', $call->getAttributes()->get('http.request.method'));
            $this->assertSame('/v1/messages', $call->getAttributes()->get('http.route'));
            $this->assertSame('https://api.example.test:8443/v1/messages', $call->getAttributes()->get('url.full'));
        }
    }

    public function testToolRunnerSpansHaveTheConversationIdOfTheClientRequestOptionsUnlessTheRunnerNamesOne(): void
    {
        $client = new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test:8443',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0, 'openTelemetry' => ['conversationId' => 'conv_client']],
            openTelemetry: ['tracerProvider' => $this->tracerProvider],
        );
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (): string => 'Sunny');

        foreach (['conv_client' => [], 'conv_runner' => ['requestOptions' => ['openTelemetry' => ['conversationId' => 'conv_runner']]]] as $conversation => $extraParams) {
            $this->exporter->getStorage()->exchangeArray([]);
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
                ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
            ]]));
            $this->transporter->addResponse(self::json(self::MESSAGE));

            $client->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather in Paris?']], model: 'claude-test', tools: [$weather], extraParams: $extraParams)->runUntilDone();

            // The tool runner span, the span of the tool run and the spans of the two requests are in one conversation.
            $conversations = [];
            foreach ($this->spans() as $span) {
                $conversations[$span->getName()][] = $span->getAttributes()->get('gen_ai.conversation.id');
            }
            ksort($conversations);
            $this->assertSame([
                'anthropic.custom_tool_use get_weather' => [$conversation],
                'anthropic.messages.create' => [$conversation, $conversation],
                'anthropic.messages.tool_runner' => [$conversation],
            ], $conversations);
        }
    }

    public function testMcpToolRunEmitsAnMcpToolSpan(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
        ]]));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $mcpClient = new class() extends McpClient {
            public function __construct()
            {
                // callTool is overridden, so the protocol the parent constructor sets up is never used.
            }

            public function callTool(string $name, array $arguments = [], ?callable $onProgress = null): CallToolResult
            {
                return new CallToolResult([new TextContent('Sunny')]);
            }
        };
        $weather = BetaMcp::tool(
            new McpTool(name: 'get_weather', title: null, inputSchema: ['type' => 'object', 'properties' => ['city' => ['type' => 'string']], 'required' => null], description: 'Weather', annotations: null),
            $mcpClient,
        );

        $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather in Paris?']], model: 'claude-test', tools: [$weather], extraParams: ['requestOptions' => RequestOptions::with(openTelemetry: ['conversationId' => 'conv_mcp'])])->runUntilDone();

        $tool = null;
        foreach ($this->spans() as $span) {
            $this->assertStringStartsNotWith('anthropic.custom_tool_use', $span->getName());
            if ('anthropic.mcp_tool_use get_weather' === $span->getName()) {
                $tool = $span;
            }
        }
        $this->assertNotNull($tool);
        $this->assertSame(SpanKind::KIND_INTERNAL, $tool->getKind());
        $this->assertSame(StatusCode::STATUS_OK, $tool->getStatus()->getCode());
        $this->assertSame('execute_tool', $tool->getAttributes()->get('gen_ai.operation.name'));
        $this->assertSame('get_weather', $tool->getAttributes()->get('gen_ai.tool.name'));
        $this->assertSame('function', $tool->getAttributes()->get('gen_ai.tool.type'));
        // The description is the MCP server's.
        $this->assertSame('Weather', $tool->getAttributes()->get('gen_ai.tool.description'));
        $this->assertSame('conv_mcp', $tool->getAttributes()->get('gen_ai.conversation.id'));
    }

    public function testToolSpanFailsWithToolErrorForAnErrorResultOrNone(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => 'x'], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => 'Error: nope', 'is_error' => true]);
        // A run that made no result, because it threw, fails too.
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_2', 'explode');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, new \stdClass, null);
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_3', 'fine');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, [], ['type' => 'tool_result', 'tool_use_id' => 'toolu_3', 'content' => [['type' => 'text', 'text' => 'done'], ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => 'image/png', 'data' => 'AAAA']]]]);

        [$failed, $threw, $fine] = $this->spans();
        $this->assertSame('anthropic.custom_tool_use lookup', $failed->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $failed->getStatus()->getCode());
        $this->assertSame('tool_error', $failed->getAttributes()->get('error.type'));
        $this->assertSame(['q' => 'x'], self::decode($failed->getAttributes()->get('gen_ai.tool.call.arguments')));
        // A content that is a string is one text block.
        $this->assertSame([['type' => 'text', 'text' => 'Error: nope']], self::decode($failed->getAttributes()->get('anthropic.tool_result.content')));

        $this->assertSame(StatusCode::STATUS_ERROR, $threw->getStatus()->getCode());
        $this->assertSame('tool_error', $threw->getAttributes()->get('error.type'));
        $this->assertSame('{}', $threw->getAttributes()->get('gen_ai.tool.call.arguments'));
        $this->assertNull($threw->getAttributes()->get('anthropic.tool_result.content'));

        $this->assertSame(StatusCode::STATUS_OK, $fine->getStatus()->getCode());
        $this->assertNull($fine->getAttributes()->get('error.type'));
        // A text block is whole, and any other block is its type only.
        $this->assertSame([['type' => 'text', 'text' => 'done'], ['type' => 'image']], self::decode($fine->getAttributes()->get('anthropic.tool_result.content')));
        foreach ([$failed, $threw, $fine] as $tool) {
            $this->assertNull($tool->getAttributes()->get('gen_ai.tool.call.result'));
        }
    }

    public function testToolSpanResultContentIsTheResultsContentBlocks(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);
        $text = ['type' => 'text', 'text' => 'found', 'citations' => [['type' => 'char_location', 'cited_text' => 'found', 'document_index' => 0, 'document_title' => 'Notes', 'start_char_index' => 0, 'end_char_index' => 5]], 'cache_control' => ['type' => 'ephemeral']];
        $searchResult = ['type' => 'search_result', 'source' => 'https://example.com', 'title' => 'Example', 'content' => [['type' => 'text', 'text' => 'body']], 'citations' => ['enabled' => true]];
        $image = ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => 'image/png', 'data' => 'AAAA']];

        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        $cited = ['type' => 'text', 'text' => 'found', 'citations' => [['type' => 'web_search_result_location', 'cited_text' => 'found', 'url' => 'https://example.com', 'title' => 'Example']]];
        Tracing::endToolUseSpan($client, $span, [], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => [$text, $searchResult, $image, [...$cited, 'citations' => [[...$cited['citations'][0], 'encrypted_index' => 'SEALED']]]]]);
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_2', 'empty');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, [], ['type' => 'tool_result', 'tool_use_id' => 'toolu_2', 'content' => null]);
        foreach ([[], new \stdClass, ''] as $index => $empty) {
            $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', "toolu_empty_{$index}", 'empty');
            $this->assertNotNull($span);
            Tracing::endToolUseSpan($client, $span, [], ['type' => 'tool_result', 'tool_use_id' => "toolu_empty_{$index}", 'content' => $empty]);
        }

        [$blocks, $none, $emptyList, $emptyObject, $emptyString] = $this->spans();
        // A text block and a search result block keep all their fields, except those whose name starts with
        // `encrypted_`. Any other block keeps only its type.
        $this->assertSame([$text, $searchResult, ['type' => 'image'], $cited], self::decode($blocks->getAttributes()->get('anthropic.tool_result.content')));
        // A result without content is an empty list, never an object or null: the attribute is always a list.
        foreach ([$none, $emptyList, $emptyObject] as $tool) {
            $this->assertSame('[]', $tool->getAttributes()->get('anthropic.tool_result.content'));
        }
        // An empty string is still a string: one text block.
        $this->assertSame([['type' => 'text', 'text' => '']], self::decode($emptyString->getAttributes()->get('anthropic.tool_result.content')));
    }

    public function testToolSpanResultOverTheLimitLosesItsLastBlocks(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);
        $half = str_repeat('z', intdiv(Content::LIMIT, 2));
        $blocks = [['type' => 'text', 'text' => $half], ['type' => 'text', 'text' => 'more'], ['type' => 'text', 'text' => $half], ['type' => 'text', 'text' => 'last']];

        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => 'x'], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => $blocks]);
        // A content that is a string is one content block, which is removed whole.
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_2', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => 'x'], ['type' => 'tool_result', 'tool_use_id' => 'toolu_2', 'content' => str_repeat('z', Content::LIMIT)]);
        // An input that is over the limit by itself is left out whole, and the result then has all of the limit.
        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_3', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => $half.$half], ['type' => 'tool_result', 'tool_use_id' => 'toolu_3', 'content' => 'found']);

        [$list, $string, $input] = $this->spans();
        // The blocks up to the first one that does not fit are whole, and the ones from it on are removed.
        $this->assertSame(array_slice($blocks, 0, 2), self::decode($list->getAttributes()->get('anthropic.tool_result.content')));
        $this->assertSame('[]', $string->getAttributes()->get('anthropic.tool_result.content'));
        $this->assertSame([['type' => 'text', 'text' => 'found']], self::decode($input->getAttributes()->get('anthropic.tool_result.content')));
        $this->assertArrayNotHasKey('gen_ai.tool.call.arguments', $input->getAttributes()->toArray());
        foreach ([$list, $string, $input] as $tool) {
            $this->assertTrue($tool->getAttributes()->get('anthropic.content.truncated'));
            $this->assertSame(StatusCode::STATUS_OK, $tool->getStatus()->getCode());
        }
        foreach ([$list, $string] as $tool) {
            $this->assertSame(['q' => 'x'], self::decode($tool->getAttributes()->get('gen_ai.tool.call.arguments')));
        }
    }

    /**
     * The cases that every SDK shares. The limit is small so that each case can be read.
     *
     * @param list<array<string, mixed>> $result
     * @param array<string, mixed>|null $expectedInput the input that the span holds, or null when it holds none
     * @param list<array<string, mixed>> $expectedResult
     */
    #[DataProvider('toolSizeBoundCases')]
    public function testToolSpanContentOverTheLimitLosesResultBlocksFromTheEnd(int $limit, mixed $input, array $result, ?array $expectedInput, array $expectedResult, bool $truncated, int $size): void
    {
        $span = $this->tracerProvider->getTracer('test')->spanBuilder('tool')->startSpan();

        Content::setToolContentAttributes($span, $input, $result, $limit);
        $span->end();

        $attributes = $this->onlySpan()->getAttributes();
        $flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        $arguments = $attributes->get('gen_ai.tool.call.arguments');
        $content = $attributes->get('anthropic.tool_result.content');
        $this->assertSame(null === $expectedInput ? null : json_encode($expectedInput, $flags), $arguments);
        $this->assertSame(json_encode($expectedResult, $flags), $content);
        $this->assertSame($truncated ? true : null, $attributes->get('anthropic.content.truncated'));
        $this->assertSame($size, strlen($arguments ?? '') + strlen($content));
    }

    /**
     * @return iterable<string, array{int, mixed, list<array<string, mixed>>, array<string, mixed>|null, list<array<string, mixed>>, bool, int}>
     */
    public static function toolSizeBoundCases(): iterable
    {
        // The input fits the bound, so it stays whole and counts. The result loses whole blocks from its end, the last one first.
        yield 'tool span blocks go from the end' => [
            152,
            ['city' => 'Paris'],
            [['type' => 'text', 'text' => 'first 111111111111111111111111111111'], ['type' => 'text', 'text' => 'second 222222222222222222222222222222'], ['type' => 'image'], ['type' => 'text', 'text' => 'fourth 444444444444444444444444444444']],
            ['city' => 'Paris'],
            [['type' => 'text', 'text' => 'first 111111111111111111111111111111'], ['type' => 'text', 'text' => 'second 222222222222222222222222222222']],
            true,
            142,
        ];

        // The input exceeds the bound by itself, so it is left out whole. The result then has all of the bound, and it fits.
        yield 'tool span arguments alone over the bound' => [
            100,
            ['text' => str_repeat('w', 150)],
            [['type' => 'text', 'text' => 'ok']],
            null,
            [['type' => 'text', 'text' => 'ok']],
            true,
            29,
        ];
    }

    public function testToolSpanInputIsLeftOutWholeOnlyWhenItExceedsTheLimitByItself(): void
    {
        $tracer = $this->tracerProvider->getTracer('test');
        // The JSON of the input is 100 bytes, then 101.
        $atTheLimit = ['q' => str_repeat('x', 92)];
        $over = ['q' => str_repeat('x', 93)];
        $result = [['type' => 'text', 'text' => 'found']];

        foreach ([[$atTheLimit, $result], [$over, $result], [$over, null]] as [$input, $blocks]) {
            $span = $tracer->spanBuilder('tool')->startSpan();
            Content::setToolContentAttributes($span, $input, $blocks, 100);
            $span->end();
        }

        [$kept, $leftOut, $withoutResult] = array_map(static fn (ImmutableSpan $span): array => $span->getAttributes()->toArray(), $this->spans());
        // An input that fills the limit is not over it. It leaves no room for the result, whose emptied list stays.
        $this->assertSame($atTheLimit, self::decode($kept['gen_ai.tool.call.arguments']));
        $this->assertSame('[]', $kept['anthropic.tool_result.content']);
        $this->assertTrue($kept['anthropic.content.truncated']);
        // One more byte, and the input is left out whole. The result then fits.
        $this->assertArrayNotHasKey('gen_ai.tool.call.arguments', $leftOut);
        $this->assertSame($result, self::decode($leftOut['anthropic.tool_result.content']));
        $this->assertTrue($leftOut['anthropic.content.truncated']);
        // A run that made no result is marked for its input too.
        $this->assertArrayNotHasKey('gen_ai.tool.call.arguments', $withoutResult);
        $this->assertArrayNotHasKey('anthropic.tool_result.content', $withoutResult);
        $this->assertTrue($withoutResult['anthropic.content.truncated']);
    }

    public function testToolSpanResultOverTheLimitIsNoContentInMetadataOnlyMode(): void
    {
        $client = $this->client();

        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        Tracing::endToolUseSpan($client, $span, ['q' => 'x'], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => str_repeat('z', Content::LIMIT)]);

        $attributes = $this->onlySpan()->getAttributes()->toArray();
        $this->assertArrayNotHasKey('gen_ai.tool.call.arguments', $attributes);
        $this->assertArrayNotHasKey('anthropic.tool_result.content', $attributes);
        $this->assertArrayNotHasKey('anthropic.content.truncated', $attributes);
    }

    public function testToolRunnerSpanHasTheOutputTypeWhenItsParametersSetAJsonOutputFormat(): void
    {
        $format = ['type' => 'json_schema', 'schema' => ['type' => 'object', 'properties' => ['answer' => ['type' => 'string']]]];
        $params = ['maxTokens' => 16, 'messages' => [['role' => 'user', 'content' => 'Hello']], 'model' => 'claude-test', 'tools' => []];
        $client = $this->client();

        foreach ([['outputConfig' => ['format' => $format]], ['outputFormat' => $format], ['outputConfig' => ['format' => BetaJSONOutputFormat::with(schema: $format['schema'])]], ['outputConfig' => ['format' => ['type' => 'text']]], ['outputConfig' => ['effort' => 'low']]] as $extraParams) {
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'content' => [['type' => 'text', 'text' => '{"answer":"hi"}']]]));
            $client->beta->messages->toolRunner(...$params, extraParams: $extraParams)->runUntilDone();
        }

        $types = [];
        foreach ($this->spans() as $span) {
            $types[$span->getName()][] = $span->getAttributes()->get('gen_ai.output.type');
        }
        $this->assertSame(['json', 'json', 'json', null, null], $types['anthropic.messages.tool_runner']);
        // Each request of the runner says the same of itself.
        $this->assertSame(['json', 'json', 'json', null, null], $types['anthropic.messages.create']);
    }

    public function testToolSpanIsCurrentWhileTheToolRuns(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => ['q' => 'x']],
        ]]));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $seen = null;
        $lookup = new BetaRunnableTool(['name' => 'lookup', 'description' => 'Looks up', 'input_schema' => ['type' => 'object', 'properties' => ['q' => ['type' => 'string']]]], static function () use (&$seen): string {
            $seen = Span::getCurrent()->getContext()->getSpanId();

            return 'ok';
        });

        $before = Context::getCurrent();

        $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Look it up']], model: 'claude-test', tools: [$lookup])->runUntilDone();

        // No span of the runner stays current once it returns.
        $this->assertSame($before, Context::getCurrent());
        $tool = null;
        foreach ($this->spans() as $span) {
            if ('anthropic.custom_tool_use lookup' === $span->getName()) {
                $tool = $span;
            }
        }
        $this->assertNotNull($tool);
        $this->assertSame($tool->getSpanId(), $seen);
        // The runner has no conversation ID, so neither has the tool span. An empty one counts as none.
        $this->assertNull($tool->getAttributes()->get('gen_ai.conversation.id'));
        Tracing::startToolUseSpan($this->client(), 'anthropic.custom_tool_use', 'toolu_2', 'lookup', null, '')?->end();
        $last = array_slice($this->spans(), -1);
        $this->assertCount(1, $last);
        $this->assertSame('anthropic.custom_tool_use lookup', $last[0]->getName());
        $this->assertNull($last[0]->getAttributes()->get('gen_ai.conversation.id'));
    }

    public function testToolContentThatJsonCannotHoldIsLeftOutAndTheSpanStillEnds(): void
    {
        $client = $this->client(['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]);

        $span = Tracing::startToolUseSpan($client, 'anthropic.custom_tool_use', 'toolu_1', 'lookup');
        $this->assertNotNull($span);
        // Not UTF-8, so it has no JSON.
        Tracing::endToolUseSpan($client, $span, ['q' => "\xB1\x31"], ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => "\xB1\x31"]);

        $tool = $this->onlySpan();
        $this->assertSame(StatusCode::STATUS_OK, $tool->getStatus()->getCode());
        $this->assertNull($tool->getAttributes()->get('gen_ai.tool.call.arguments'));
        $this->assertNull($tool->getAttributes()->get('anthropic.tool_result.content'));
    }

    public function testToolRunnerStoppedEarlyLeavesItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
        ]]));
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (array $input): string => 'Sunny');

        $runner = $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather?']], model: 'claude-test', tools: [$weather]);
        foreach ($runner as $message) {
            break;
        }

        $toolRunnerSpan = null;
        foreach ($this->spans() as $span) {
            if ('anthropic.messages.tool_runner' === $span->getName()) {
                $toolRunnerSpan = $span;
            }
        }
        $this->assertNotNull($toolRunnerSpan);
        $this->assertSame(StatusCode::STATUS_UNSET, $toolRunnerSpan->getStatus()->getCode());
    }

    public function testToolSpanHasTheDescriptionOfTheToolDefinitionUnlessItHasNoneOrOneThatIsNotUtf8(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'model', 'input' => new \stdClass],
            ['type' => 'tool_use', 'id' => 'toolu_2', 'name' => 'none', 'input' => new \stdClass],
            ['type' => 'tool_use', 'id' => 'toolu_3', 'name' => 'empty', 'input' => new \stdClass],
        ]]));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $schema = ['type' => 'object', 'properties' => new \stdClass];
        $run = static fn (): string => 'ok';

        $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Go']], model: 'claude-test', tools: [
            new BetaRunnableTool(BetaTool::with(inputSchema: ['type' => 'object'], name: 'model', description: 'Déjà vu'), $run),
            new BetaRunnableTool(['name' => 'none', 'input_schema' => $schema], $run),
            new BetaRunnableTool(['name' => 'empty', 'description' => '', 'input_schema' => $schema], $run),
        ])->runUntilDone();
        // Not UTF-8: an exporter would fail on it.
        Tracing::startToolUseSpan($this->client(), 'anthropic.custom_tool_use', 'toolu_4', 'binary', "\xB1\x31")?->end();

        $descriptions = [];
        foreach ($this->spans() as $span) {
            if (str_starts_with($span->getName(), 'anthropic.custom_tool_use ')) {
                $descriptions[$span->getName()] = $span->getAttributes()->get('gen_ai.tool.description');
            }
        }
        $this->assertSame([
            'anthropic.custom_tool_use model' => 'Déjà vu',
            'anthropic.custom_tool_use none' => null,
            'anthropic.custom_tool_use empty' => null,
            'anthropic.custom_tool_use binary' => null,
        ], $descriptions);
    }

    public function testToolSpanHasTheToolsetNameOfItsToolUseBlockWhenTheBlockHasOne(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'screenshot', 'toolset_name' => 'computer', 'input' => new \stdClass],
            ['type' => 'tool_use', 'id' => 'toolu_2', 'name' => 'get_weather', 'input' => new \stdClass],
            ['type' => 'tool_use', 'id' => 'toolu_3', 'name' => 'get_time', 'toolset_name' => null, 'input' => new \stdClass],
        ]]));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $tool = static fn (string $name): BetaRunnableTool => new BetaRunnableTool(['name' => $name, 'input_schema' => ['type' => 'object', 'properties' => new \stdClass]], static fn (): string => 'ok');

        $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Go']], model: 'claude-test', tools: [$tool('screenshot'), $tool('get_weather'), $tool('get_time')])->runUntilDone();

        $toolsets = [];
        foreach ($this->spans() as $span) {
            if (str_starts_with($span->getName(), 'anthropic.custom_tool_use ')) {
                $toolsets[$span->getName()] = $span->getAttributes()->get('anthropic.toolset.name');
            }
        }
        $this->assertSame([
            'anthropic.custom_tool_use screenshot' => 'computer',
            'anthropic.custom_tool_use get_weather' => null,
            'anthropic.custom_tool_use get_time' => null,
        ], $toolsets);
    }

    public function testToolRunnerBehavesTheSameWithTracingOffSampledOutAndRecording(): void
    {
        $sampledOut = new TracerProvider(new SimpleSpanProcessor($this->exporter), new AlwaysOffSampler);
        $outcomes = [];
        foreach ([false, ['tracerProvider' => $sampledOut], ['tracerProvider' => $this->tracerProvider, 'traces' => ['contentMode' => 'content']]] as $openTelemetry) {
            $transporter = new MockClient;
            $transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_1', 'stop_reason' => 'tool_use', 'content' => [
                ['type' => 'text', 'text' => 'Checking.'],
                ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
            ]]));
            $transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_2']));
            $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test:8443', requestOptions: ['transporter' => $transporter, 'maxRetries' => 0], openTelemetry: $openTelemetry);
            $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (array $input): string => 'Sunny');

            $runner = $client->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather in Paris?']], model: 'claude-test', tools: [$weather]);
            $messages = [];
            foreach ($runner as $key => $message) {
                $messages[$key] = $message->id;
            }

            $outcomes[] = [
                'messages' => $messages,
                'bodies' => array_map(static fn (RequestInterface $request): string => (string) $request->getBody(), $transporter->getRequests()),
                // The conversation the runner built, from the Messages it received.
                'conversation' => json_encode($runner->getParams()['messages'], JSON_THROW_ON_ERROR),
            ];
        }

        $this->assertSame([0 => 'msg_1', 1 => 'msg_2'], $outcomes[0]['messages']);
        $this->assertCount(2, $outcomes[0]['bodies']);
        $this->assertStringContainsString('"tool_use_id":"toolu_1"', $outcomes[0]['bodies'][1]);
        $this->assertSame($outcomes[0], $outcomes[1]);
        $this->assertSame($outcomes[0], $outcomes[2]);
        // Only the recording client exported spans.
        $this->assertSame(['anthropic.messages.create', 'anthropic.custom_tool_use get_weather', 'anthropic.messages.create', 'anthropic.messages.tool_runner'], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $this->spans()));
    }

    public function testEveryStepOfTheToolRunnerRunsUnderTheToolRunnerSpanWhateverContextResumesIt(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_1', 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => ['q' => 'x']],
        ]]));
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_2']));
        $tracer = $this->tracerProvider->getTracer('application');
        // The application's own instrumentation: a middleware and a tool that each start a span.
        $middleware = static function (RequestInterface $request, \Closure $next) use ($tracer): ResponseInterface {
            $span = $tracer->spanBuilder('middleware')->startSpan();

            try {
                $response = $next($request);
                self::assertInstanceOf(ResponseInterface::class, $response);

                return $response;
            } finally {
                $span->end();
            }
        };
        $lookup = new BetaRunnableTool(['name' => 'lookup', 'description' => 'Looks up', 'input_schema' => ['type' => 'object', 'properties' => ['q' => ['type' => 'string']]]], static function () use ($tracer): string {
            $tracer->spanBuilder('in tool')->startSpan()->end();

            return 'ok';
        });
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test:8443', requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0, 'middleware' => [$middleware]], openTelemetry: ['tracerProvider' => $this->tracerProvider]);
        $steps = $client->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Look it up']], model: 'claude-test', tools: [$lookup])->getIterator();

        // The first step runs from the trace the loop starts in.
        $startingSpan = $tracer->spanBuilder('starting trace')->startSpan();
        $startingOtelContext = $startingSpan->storeInContext(Context::getCurrent());
        $scope = $startingOtelContext->activate();

        try {
            $this->assertSame('msg_1', $steps->current()->id);
            // Between two steps the application's context is its own.
            $this->assertSame($startingOtelContext, Context::getCurrent());
        } finally {
            $scope->detach();
        }
        $startingSpan->end();

        // The second step, which runs the tool and sends the next request, runs from an unrelated trace.
        $unrelatedSpan = $tracer->spanBuilder('unrelated trace')->setParent(false)->startSpan();
        $unrelatedOtelContext = $unrelatedSpan->storeInContext(Context::getCurrent());
        $scope = $unrelatedOtelContext->activate();

        try {
            $steps->next();
            $this->assertSame('msg_2', $steps->current()->id);
            $this->assertSame($unrelatedOtelContext, Context::getCurrent());
            $steps->next();
            $this->assertFalse($steps->valid());
            $this->assertSame($unrelatedOtelContext, Context::getCurrent());
        } finally {
            $scope->detach();
        }
        $unrelatedSpan->end();

        $byName = [];
        foreach ($this->spans() as $span) {
            $byName[$span->getName()][] = $span;
        }
        $toolRunnerSpan = $byName['anthropic.messages.tool_runner'][0];
        $this->assertSame($byName['starting trace'][0]->getSpanId(), $toolRunnerSpan->getParentSpanId());
        $this->assertSame(StatusCode::STATUS_OK, $toolRunnerSpan->getStatus()->getCode());
        // Every request and tool run is a child of the tool runner span, and what runs inside them is below it.
        [$firstCall, $secondCall] = $byName['anthropic.messages.create'];
        $toolUseSpan = $byName['anthropic.custom_tool_use lookup'][0];
        foreach ([$firstCall, $secondCall, $toolUseSpan] as $child) {
            $this->assertSame($toolRunnerSpan->getSpanId(), $child->getParentSpanId());
        }
        $this->assertSame([$firstCall->getSpanId(), $secondCall->getSpanId()], array_map(static fn (ImmutableSpan $span): string => $span->getParentSpanId(), $byName['middleware']));
        $this->assertSame($toolUseSpan->getSpanId(), $byName['in tool'][0]->getParentSpanId());
        // Nothing lands in the unrelated trace.
        foreach ($this->spans() as $span) {
            if ('unrelated trace' !== $span->getName()) {
                $this->assertSame($toolRunnerSpan->getTraceId(), $span->getTraceId(), $span->getName());
            }
        }
        $this->assertNotSame($toolRunnerSpan->getTraceId(), $byName['unrelated trace'][0]->getTraceId());
    }

    public function testToolRunnerLeftUnreadKeepsItsSpanOpenUntilPhpFreesIt(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
        ]]));
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (array $input): string => 'Sunny');
        $before = Context::getCurrent();

        $steps = $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather?']], model: 'claude-test', tools: [$weather])->getIterator();
        $steps->current();

        // The application holds the runner without reading on: the tool runner span is open, and not current.
        $this->assertSame(['anthropic.messages.create'], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $this->spans()));
        $this->assertSame($before, Context::getCurrent());

        unset($steps);
        gc_collect_cycles();

        $spans = $this->spans();
        $this->assertSame(['anthropic.messages.create', 'anthropic.messages.tool_runner'], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $spans));
        $this->assertSame(StatusCode::STATUS_UNSET, $spans[1]->getStatus()->getCode());
        $this->assertNull($spans[1]->getAttributes()->get('error.type'));
        $this->assertSame($before, Context::getCurrent());
    }

    public function testErrorThrownIntoTheToolRunnerStopsItAndLeavesItsSpanUnset(): void
    {
        $this->transporter->addResponse(self::json([...self::MESSAGE, 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
        ]]));
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static fn (array $input): string => 'Sunny');

        $steps = $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather?']], model: 'claude-test', tools: [$weather])->getIterator();
        $steps->current();

        try {
            $steps->throw(new \DomainException('stop'));
            $this->fail('expected the error back');
        } catch (\DomainException) {
        }
        $this->assertFalse($steps->valid());

        $spans = $this->spans();
        $this->assertSame(['anthropic.messages.create', 'anthropic.messages.tool_runner'], array_map(static fn (ImmutableSpan $span): string => $span->getName(), $spans));
        $this->assertSame(StatusCode::STATUS_UNSET, $spans[1]->getStatus()->getCode());
        $this->assertCount(1, $this->transporter->getRequests());
    }

    public function testToolRunnerThatFailsHasTheErrorTypeOfTheFailedCall(): void
    {
        $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']], status: 429));
        $before = Context::getCurrent();

        try {
            $this->client()->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather?']], model: 'claude-test', tools: [])->runUntilDone();
            $this->fail('expected a RateLimitException');
        } catch (RateLimitException) {
        }

        $this->assertSame($before, Context::getCurrent());
        [$call, $toolRunnerSpan] = $this->spans();
        $this->assertSame('anthropic.messages.tool_runner', $toolRunnerSpan->getName());
        $this->assertSame($toolRunnerSpan->getSpanId(), $call->getParentSpanId());
        $this->assertSame(StatusCode::STATUS_ERROR, $toolRunnerSpan->getStatus()->getCode());
        $this->assertSame('rate_limit_error', $toolRunnerSpan->getAttributes()->get('error.type'));
    }

    /**
     * Telemetry that throws leaves the tool runner's loop as it is without tracing: its tools run, it returns the final message, and a call that fails keeps its own exception.
     */
    #[DataProvider('telemetryThatThrows')]
    public function testTelemetryThatThrowsLeavesTheToolRunnerLoopAsItIs(string $where): void
    {
        [$provider, $propagator] = $this->telemetryThatThrowsAt($where);
        $client = $this->client(['tracerProvider' => $provider]);
        $toolUse = static fn (): ResponseInterface => self::json([...self::MESSAGE, 'id' => 'msg_1', 'stop_reason' => 'tool_use', 'content' => [
            ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['city' => 'Paris']],
        ]]);
        $ran = 0;
        $weather = new BetaRunnableTool(['name' => 'get_weather', 'description' => 'Weather', 'input_schema' => ['type' => 'object', 'properties' => ['city' => ['type' => 'string']]]], static function (array $input) use (&$ran): string {
            ++$ran;

            return 'Sunny';
        });
        $toolRunner = static fn (): BetaToolRunner => $client->beta->messages->toolRunner(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Weather in Paris?']], model: 'claude-test', tools: [$weather]);
        $before = Context::getCurrent();
        $scope = null === $propagator ? null : Configurator::create()->withPropagator($propagator)->activate();

        try {
            // The loop runs its tool, sends the result back, and returns the final message.
            $this->transporter->addResponse($toolUse());
            $this->transporter->addResponse(self::json([...self::MESSAGE, 'id' => 'msg_2']));
            $this->assertSame('msg_2', $toolRunner()->runUntilDone()->id);
            $this->assertSame(1, $ran);
            $this->assertStringContainsString('"content":"Sunny"', (string) $this->lastRequest()->getBody());

            // A loop the application stops early and drops.
            $this->transporter->addResponse($toolUse());
            foreach ($toolRunner() as $message) {
                break;
            }
            unset($message);
            gc_collect_cycles();

            // A call that fails keeps its own exception.
            $this->transporter->addResponse(self::json(['type' => 'error', 'error' => ['type' => 'rate_limit_error', 'message' => 'slow down']], status: 429));

            try {
                $toolRunner()->runUntilDone();
                $this->fail('expected a RateLimitException');
            } catch (RateLimitException) {
            }
        } finally {
            $scope?->detach();
        }
        $this->assertSame($before, Context::getCurrent());
    }

    /**
     * Registers this test's tracer provider, which the spans of a client that names none go to.
     */
    private function registerTracerProvider(): void
    {
        $this->scope->detach();
        $this->scope = Configurator::create()->withTracerProvider($this->tracerProvider)->withPropagator(TraceContextPropagator::getInstance())->activate();
    }

    /**
     * A client that is given no `openTelemetry` option, which the environment variables apply to. Its spans go to the registered tracer provider, which is this test's from here on.
     */
    private function clientWithoutTheOption(): Client
    {
        $this->registerTracerProvider();

        return new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test:8443',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
        );
    }

    /**
     * @param OpenTelemetryOptions|null $openTelemetry
     */
    private function client(array|false|null $openTelemetry = null): Client
    {
        return new Client(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test:8443',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
            openTelemetry: $openTelemetry ?? ['tracerProvider' => $this->tracerProvider],
        );
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

    private function onlySpan(): ImmutableSpan
    {
        $spans = $this->spans();
        $this->assertCount(1, $spans);

        return $spans[0];
    }

    private function lastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        $this->assertInstanceOf(RequestInterface::class, $request);

        return $request;
    }

    /**
     * Runs `$call` under a parent span that has a trace state, with baggage, and with a propagator that writes both, as the OpenTelemetry SDK's default one does, or with `$propagator`.
     *
     * @param \Closure(): void $call
     */
    private function underAParentSpanWithBaggage(\Closure $call, ?TextMapPropagatorInterface $propagator = null): void
    {
        $parent = Span::wrap(SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED, new TraceState('vendor=value')));
        $parentOtelContext = Context::getCurrent()->withContextValue($parent)->withContextValue(Baggage::getBuilder()->set('user_id', '12345')->build());
        $propagator ??= new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $scope = Configurator::create()->withPropagator($propagator)->storeInContext($parentOtelContext)->activate();

        try {
            $call();
        } finally {
            $scope->detach();
        }
    }

    /**
     * The two requests of an API call that the server redirects to `$location`: the one to the API and the one that follows the redirect. The call runs under a parent span that has a trace state, with baggage, and with a propagator that writes both, as the OpenTelemetry SDK's default one does, or with `$propagator`. The client leaves `propagation` unset unless `$propagation` says otherwise.
     *
     * @return array{RequestInterface, RequestInterface}
     */
    private function redirectedRequests(string $location, ?TextMapPropagatorInterface $propagator = null, ?bool $propagation = null): array
    {
        $sent = count($this->transporter->getRequests());
        $this->transporter->addResponse(self::json([], 307, ['Location' => $location]));
        $this->transporter->addResponse(self::json(self::MESSAGE));
        $parent = Span::wrap(SpanContext::create('0af7651916cd43dd8448eb211c80319c', 'b7ad6b7169203331', TraceFlags::SAMPLED, new TraceState('vendor=value')));
        $parentOtelContext = Context::getCurrent()->withContextValue($parent)->withContextValue(Baggage::getBuilder()->set('user_id', '12345')->build());
        $propagator ??= new MultiTextMapPropagator([TraceContextPropagator::getInstance(), BaggagePropagator::getInstance()]);
        $scope = Configurator::create()->withPropagator($propagator)->storeInContext($parentOtelContext)->activate();

        try {
            $this->client(['tracerProvider' => $this->tracerProvider, 'propagation' => $propagation])->messages->create(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test');
        } finally {
            $scope->detach();
        }

        $requests = array_slice($this->transporter->getRequests(), $sent);
        $this->assertCount(2, $requests);

        return [$requests[0], $requests[1]];
    }

    /**
     * The events of a streamed Message. Without `$stop`, the stream ends after the first text delta.
     *
     * @return list<array<string, mixed>>
     */
    private static function streamEvents(bool $stop = true, string $id = 'msg_1'): array
    {
        $events = [
            ['type' => 'message_start', 'message' => [...self::MESSAGE, 'id' => $id, 'content' => [], 'stop_reason' => null, 'usage' => [...self::MESSAGE['usage'], 'output_tokens' => 1]]],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'Hi']],
        ];
        if ($stop) {
            array_push(
                $events,
                ['type' => 'content_block_stop', 'index' => 0],
                ['type' => 'message_delta', 'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]],
                ['type' => 'message_stop'],
            );
        }

        return $events;
    }

    /**
     * The events of a streamed Message whose content is a text block and a tool use.
     *
     * @return list<array<string, mixed>>
     */
    private static function toolUseStreamEvents(): array
    {
        return [
            ['type' => 'message_start', 'message' => [...self::MESSAGE, 'content' => [], 'stop_reason' => null]],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'H']],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'i']],
            ['type' => 'content_block_stop', 'index' => 0],
            ['type' => 'content_block_start', 'index' => 1, 'content_block' => ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'lookup', 'input' => new \stdClass]],
            ['type' => 'content_block_delta', 'index' => 1, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"q":']],
            ['type' => 'content_block_delta', 'index' => 1, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '"x"}']],
            ['type' => 'content_block_stop', 'index' => 1],
            ['type' => 'message_delta', 'delta' => ['stop_reason' => 'tool_use', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]],
            ['type' => 'message_stop'],
        ];
    }

    /**
     * The events of a streamed Message whose content is `$content`. The input of a block arrives as one delta.
     *
     * @param list<array<string, mixed>> $content
     *
     * @return list<array<string, mixed>>
     */
    private static function blockStreamEvents(array $content): array
    {
        $events = [['type' => 'message_start', 'message' => [...self::MESSAGE, 'content' => [], 'stop_reason' => null]]];
        foreach ($content as $index => $block) {
            $input = $block['input'] ?? null;
            $events[] = ['type' => 'content_block_start', 'index' => $index, 'content_block' => null === $input ? $block : [...$block, 'input' => new \stdClass]];
            if (null !== $input) {
                $events[] = ['type' => 'content_block_delta', 'index' => $index, 'delta' => ['type' => 'input_json_delta', 'partial_json' => json_encode($input, JSON_THROW_ON_ERROR)]];
            }
            $events[] = ['type' => 'content_block_stop', 'index' => $index];
        }
        $events[] = ['type' => 'message_delta', 'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => ['output_tokens' => 7]];
        $events[] = ['type' => 'message_stop'];

        return $events;
    }

    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     */
    private static function json(array $body, int $status = 200, array $headers = []): ResponseInterface
    {
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, JSON_THROW_ON_ERROR)))
        ;
        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        return $response;
    }

    /**
     * @param list<array<string, mixed>> $events
     */
    private static function sse(array $events): ResponseInterface
    {
        $body = '';
        foreach ($events as $event) {
            $type = $event['type'] ?? null;
            $body .= 'event: '.(is_string($type) ? $type : 'unknown')."\ndata: ".json_encode($event, JSON_THROW_ON_ERROR)."\n\n";
        }

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body))
        ;
    }

    /**
     * @param list<array<string, mixed>> $lines
     */
    private static function jsonl(array $lines, string $tail = ''): ResponseInterface
    {
        $body = '';
        foreach ($lines as $line) {
            $body .= json_encode($line, JSON_THROW_ON_ERROR)."\n";
        }

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/x-jsonl')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body.$tail))
        ;
    }

    /**
     * One line of a batch's results: a request that succeeded with {@see self::MESSAGE}.
     *
     * @return array<string, mixed>
     */
    private static function batchResult(string $customId): array
    {
        return ['custom_id' => $customId, 'result' => ['type' => 'succeeded', 'message' => self::MESSAGE]];
    }

    /**
     * The bytes that the content attributes of `$span` hold together.
     */
    private static function contentSize(ImmutableSpan $span): int
    {
        $size = 0;
        foreach (['gen_ai.system_instructions', 'gen_ai.input.messages', 'gen_ai.output.messages'] as $attribute) {
            $json = $span->getAttributes()->get($attribute) ?? '';
            self::assertIsString($json);
            $size += strlen($json);
        }

        return $size;
    }

    /**
     * The parts of the one message of `$json`, the value of `gen_ai.output.messages`.
     *
     * @return list<array{type: string, content: string}>
     */
    private static function outputParts(mixed $json): array
    {
        $message = self::decode($json)[0] ?? null;
        self::assertIsArray($message);
        $parts = $message['parts'] ?? null;
        self::assertIsArray($parts);

        return self::textParts($parts);
    }

    /**
     * `$parts`, each of which has a string as its content.
     *
     * @param array<mixed> $parts
     *
     * @return list<array{type: string, content: string}>
     */
    private static function textParts(array $parts): array
    {
        $texts = [];
        foreach ($parts as $part) {
            self::assertIsArray($part);
            $type = $part['type'] ?? null;
            $content = $part['content'] ?? null;
            self::assertIsString($type);
            self::assertIsString($content);
            $texts[] = ['type' => $type, 'content' => $content];
        }

        return $texts;
    }

    /**
     * @return array<mixed>
     */
    private static function decode(mixed $json): array
    {
        self::assertIsString($json);
        $value = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        self::assertIsArray($value);

        return $value;
    }
}
