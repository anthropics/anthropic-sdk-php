<?php

namespace Tests\Core;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\Utils;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/**
 * How a stream of server-sent events or of JSON lines lets go of its response, on a client that sets nothing up for
 * OpenTelemetry and on one whose calls have recording spans.
 *
 * @internal
 */
#[CoversNothing]
final class StreamCloseTest extends TestCase
{
    private const ITEMS = 4;

    #[Test]
    #[DataProvider('streams')]
    public function testCloseBeforeTheFirstItemClosesTheBodyWithoutReadingIt(string $kind, bool $traced): void
    {
        [$stream, $body, $calls] = $this->open($kind, $traced);

        $stream->close();

        $this->assertSame(['close'], $calls->getArrayCopy());
        $this->assertFalse($body->isReadable());
        $this->assertSame([], iterator_to_array($stream, false));
        $this->assertNotContains('read', $calls->getArrayCopy());
    }

    #[Test]
    #[DataProvider('streams')]
    public function testCloseWhileReadingClosesTheBodyAndEndsTheStream(string $kind, bool $traced): void
    {
        [$stream, $body, $calls] = $this->open($kind, $traced);

        $items = 0;
        foreach ($stream as $_) {
            ++$items;
            $this->assertTrue($body->isReadable());
            $this->assertFalse($body->eof());
            $stream->close();
            $this->assertFalse($body->isReadable());
        }

        // The loop that closed the stream got nothing more, and neither does a new one.
        $this->assertSame(1, $items);
        $this->assertSame([], iterator_to_array($stream, false));
        $closedAt = array_search('close', $calls->getArrayCopy(), true);
        $this->assertIsInt($closedAt);
        $this->assertGreaterThan(0, $closedAt);
        $this->assertNotContains('read', array_slice($calls->getArrayCopy(), $closedAt));
    }

    #[Test]
    #[DataProvider('streams')]
    public function testCloseAgainDoesNothing(string $kind, bool $traced): void
    {
        [$unread] = $this->open($kind, $traced);
        $unread->close();
        $unread->close();
        $this->assertSame([], iterator_to_array($unread, false));

        [$partWay, $body, $calls] = $this->open($kind, $traced);
        foreach ($partWay as $_) {
            break;
        }
        $partWay->close();
        $reads = count(array_keys($calls->getArrayCopy(), 'read', true));
        $partWay->close();

        $this->assertSame([], iterator_to_array($partWay, false));
        $this->assertFalse($body->isReadable());
        $this->assertCount($reads, array_keys($calls->getArrayCopy(), 'read', true));
    }

    #[Test]
    #[DataProvider('streams')]
    public function testStreamReadToItsEndClosesTheBody(string $kind, bool $traced): void
    {
        [$stream, $body] = $this->open($kind, $traced);

        $this->assertCount(self::ITEMS, iterator_to_array($stream, false));
        $this->assertFalse($body->isReadable());

        // Closing a stream that has ended is allowed.
        $stream->close();
        $this->assertSame([], iterator_to_array($stream, false));
    }

    /**
     * @return iterable<string, array{string, bool}>
     */
    public static function streams(): iterable
    {
        yield 'server-sent events' => ['sse', false];

        yield 'json lines' => ['jsonl', false];

        yield 'traced server-sent events' => ['sse', true];

        yield 'traced json lines' => ['jsonl', true];
    }

    /**
     * A stream of {@see self::ITEMS} items from a client with the default options, or with a tracer provider when
     * `$traced`, the body of its response, which gives a few bytes to a read so that the first item leaves most of it
     * unread, and the reads and closes that the body gets.
     *
     * @return array{BaseStream<covariant mixed>, StreamInterface, \ArrayObject<int, string>}
     */
    private function open(string $kind, bool $traced): array
    {
        $message = ['id' => 'msg_1', 'type' => 'message', 'role' => 'assistant', 'model' => 'claude-test', 'content' => [], 'stop_reason' => null, 'stop_sequence' => null, 'usage' => ['input_tokens' => 1, 'output_tokens' => 1]];
        $bytes = '';
        if ('sse' === $kind) {
            $events = [
                ['type' => 'message_start', 'message' => $message],
                ['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']],
                ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'Hi']],
                ['type' => 'content_block_stop', 'index' => 0],
            ];
            foreach ($events as $event) {
                $bytes .= "event: {$event['type']}\ndata: ".json_encode($event, JSON_THROW_ON_ERROR)."\n\n";
            }
        } else {
            for ($i = 1; $i <= self::ITEMS; ++$i) {
                $bytes .= json_encode(['custom_id' => "req_{$i}", 'result' => ['type' => 'succeeded', 'message' => [...$message, 'stop_reason' => 'end_turn']]], JSON_THROW_ON_ERROR)."\n";
            }
        }

        /** @var \ArrayObject<int, string> $calls */
        $calls = new \ArrayObject;
        $body = new class(Utils::streamFor($bytes), $calls) implements StreamInterface {
            use StreamDecoratorTrait;

            /**
             * @param \ArrayObject<int, string> $calls
             */
            public function __construct(private StreamInterface $stream, private \ArrayObject $calls) {}

            public function read($length): string
            {
                $this->calls[] = 'read';

                return $this->stream->read(min($length, 16));
            }

            public function close(): void
            {
                $this->calls[] = 'close';
                $this->stream->close();
            }
        };
        $transporter = new MockClient;
        $transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', 'sse' === $kind ? 'text/event-stream' : 'application/x-jsonl')
                ->withBody($body)
        );
        $openTelemetry = $traced ? ['tracerProvider' => new TracerProvider(new SimpleSpanProcessor(new InMemoryExporter))] : null;
        $client = new Client(apiKey: 'test-api-key', baseUrl: 'https://api.example.test', requestOptions: ['transporter' => $transporter, 'maxRetries' => 0], openTelemetry: $openTelemetry);

        $stream = 'sse' === $kind
            ? $client->messages->createStream(maxTokens: 16, messages: [['role' => 'user', 'content' => 'Hello']], model: 'claude-test')
            : $client->messages->batches->resultsStream('msgbatch_1');

        return [$stream, $body, $calls];
    }
}
