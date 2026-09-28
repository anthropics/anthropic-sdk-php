<?php

namespace Tests\Core;

use Anthropic\Core\Implementation\StreamingHttpClient;
use Anthropic\Core\Util;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class StreamingHttpClientTest extends TestCase
{
    public function testReturnsErrorResponsesInsteadOfThrowing(): void
    {
        // PSR-18 sendRequest must return the response for every HTTP status;
        // the SDK's retry loop and middleware rely on it. Guzzle's send()
        // throws on 4xx/5xx unless http_errors is disabled.
        $mock = new MockHandler([
            new Response(400, ['Content-Type' => 'application/json'], '{"type":"error"}'),
        ]);
        $client = new StreamingHttpClient(new GuzzleClient(['handler' => HandlerStack::create($mock)]));

        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', 'http://localhost/v1/messages')
        ;

        $response = $client->sendRequest($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('{"type":"error"}', (string) $response->getBody());
    }

    public function testYieldsChunkedBodyAsItArrives(): void
    {
        // The first chunk comes 0.2 s after the headers because PHP hands over at once what arrives with them;
        // a read that waits for a full buffer returns both chunks.
        $child = proc_open([PHP_BINARY, '-r', <<<'PHP'
            $server = stream_socket_server('tcp://127.0.0.1:0');
            echo stream_socket_get_name($server, false), "\n";
            $conn = stream_socket_accept($server, 30);
            while (!in_array(fgets($conn), ["\r\n", false], true));
            fwrite($conn, "HTTP/1.1 200 OK\r\nTransfer-Encoding: chunked\r\n\r\n");
            usleep(200_000);
            fwrite($conn, "5\r\nhello\r\n");
            sleep(5);
            fwrite($conn, "4\r\nlate\r\n0\r\n\r\n");
            PHP], [1 => ['pipe', 'w']], $pipes);
        $this->assertIsResource($child);

        try {
            $address = trim((string) fgets($pipes[1]));
            $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', "http://{$address}/");
            $body = (new StreamingHttpClient(new GuzzleClient))->sendRequest($request)->getBody();

            $this->assertSame('hello', Util::streamIterator($body)->current());
        } finally {
            proc_terminate($child);
            proc_close($child);
        }
    }
}
