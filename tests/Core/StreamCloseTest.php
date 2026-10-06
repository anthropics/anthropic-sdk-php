<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Core\Util;
use Anthropic\JsonLStream;
use Anthropic\SSEStream;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/** @internal */
#[CoversNothing]
final class StreamCloseTest extends TestCase
{
    #[DataProvider('formats')]
    public function testCloseBeforeFirstReadNeverReadsTheBody(bool $sse): void
    {
        [$stream, $body] = $this->makeStream($sse);
        $body->failOnRead = true;
        $stream->close();
        $this->assertSame(0, $body->reads);
        $this->assertFalse($body->isReadable());
        $this->assertSame([], iterator_to_array($stream));
        $stream->close();
        $this->assertSame(0, $body->reads);
    }

    #[DataProvider('formats')]
    public function testObtainingAnIteratorBeforeCloseDoesNotStartIt(bool $sse): void
    {
        [$stream, $body] = $this->makeStream($sse);
        $iterator = $stream->getIterator();
        $stream->close();
        $this->assertSame([], iterator_to_array($iterator));
        $this->assertSame(0, $body->reads);
        $this->assertFalse($body->isReadable());
    }

    #[DataProvider('formats')]
    public function testClosingAfterOneItemStopsBufferedAndUnreadData(bool $sse): void
    {
        [$stream, $body] = $this->makeStream($sse);
        $iterator = $stream->getIterator();
        $iterator->rewind();
        $this->assertSame(['value' => 1], $iterator->current());
        $readCount = $body->reads;
        $stream->close();
        $iterator->next();
        $this->assertFalse($iterator->valid());
        $this->assertSame($readCount, $body->reads);
        $this->assertFalse($body->isReadable());
    }

    #[DataProvider('formats')]
    public function testOrdinaryDrainStillYieldsEverythingAndCloses(bool $sse): void
    {
        [$stream, $body] = $this->makeStream($sse);
        $this->assertSame([['value' => 1], ['value' => 2]], iterator_to_array($stream));
        $this->assertFalse($body->isReadable());
        $stream->close();
        $this->assertFalse($body->isReadable());
    }

    /** @return iterable<string, array{bool}> */
    public static function formats(): iterable
    {
        yield 'SSE' => [true];

        yield 'JSONL' => [false];
    }

    /** @return array{SSEStream<mixed>|JsonLStream<mixed>, CountingReadBody} */
    private function makeStream(bool $sse): array
    {
        $wire = $sse ? "event: message\ndata: {\"value\":1}\n\nevent: message\ndata: {\"value\":2}\n\n" : "{\"value\":1}\n{\"value\":2}\n";
        $body = new CountingReadBody(Utils::streamFor($wire));
        $factory = new HttpFactory;
        $response = $factory->createResponse(200)
            ->withHeader('Content-Type', $sse ? 'text/event-stream' : 'application/jsonl')
            ->withBody($body)
        ;
        $request = $factory->createRequest('GET', 'http://localhost/stream');
        $decoded = Util::decodeContent($response);
        $stream = $sse ? new SSEStream('mixed', $request, $response, $decoded) : new JsonLStream('mixed', $request, $response, $decoded);

        return [$stream, $body];
    }
}

/** @internal */
final class CountingReadBody implements StreamInterface
{
    use StreamDecoratorTrait;
    public int $reads = 0;
    public bool $failOnRead = false;

    public function __construct(private StreamInterface $stream) {}

    public function read($length): string
    {
        ++$this->reads;
        if ($this->failOnRead) {
            throw new \RuntimeException('Closing must not perform a read');
        }

        return $this->stream->read($length);
    }
}
