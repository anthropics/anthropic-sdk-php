<?php

namespace Tests\Core;

use Anthropic\Core\Implementation\StreamingHttpClient;
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
}
