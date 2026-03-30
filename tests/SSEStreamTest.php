<?php

namespace Tests;

use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\ErrorType;
use Anthropic\SSEStream;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class SSEStreamTest extends TestCase
{
    public function testStreamingErrorIncludesType(): void
    {
        $stream = $this->makeSSEStream([
            ['event' => 'error', 'data' => '{"type":"error","error":{"type":"overloaded_error","message":"Overloaded"}}'],
        ]);

        $this->expectException(APIStatusException::class);

        try {
            iterator_to_array($stream);
        } catch (APIStatusException $e) {
            $this->assertSame(ErrorType::OVERLOADED_ERROR, $e->type);

            throw $e;
        }
    }

    /**
     * @param list<array{event: string, data: string}> $events
     *
     * @return SSEStream<mixed>
     */
    private function makeSSEStream(array $events): SSEStream
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', 'https://api.anthropic.com/v1/messages');

        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(''));

        $generator = (function () use ($events) {
            yield from $events;
        })();

        /** @var SSEStream<mixed> */
        return new SSEStream(
            convert: 'string',
            request: $request,
            response: $response,
            parsedBody: $generator,
        );
    }
}
