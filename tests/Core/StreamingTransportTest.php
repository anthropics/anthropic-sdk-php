<?php

namespace Tests\Core;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class StreamingTransportTest extends TestCase
{
    #[Test]
    public function testIsStreamingRequestTable(): void
    {
        $factory = Psr17FactoryDiscovery::findRequestFactory();
        $cases = [
            'text/event-stream' => true,
            'application/x-ndjson' => true,
            'application/x-ldjson' => true,
            'application/jsonl' => true,
            'application/x-jsonl' => true,
            'text/event-stream; charset=utf-8' => true,
            'application/json' => false,
            'text/plain' => false,
            '' => false,
        ];

        foreach ($cases as $accept => $expected) {
            $req = $factory->createRequest('GET', 'http://localhost');
            if ('' !== $accept) {
                $req = $req->withHeader('Accept', $accept);
            }
            $this->assertSame(
                $expected,
                Util::isStreamingRequest($req),
                "Accept: '{$accept}'",
            );
        }
    }

    #[Test]
    public function testRoutesNonStreamingRequestToTransporter(): void
    {
        [$client, $plain, $streaming] = $this->buildClient();

        $client->request('GET', '/');

        $this->assertCount(1, $plain->getRequests());
        $this->assertCount(0, $streaming->getRequests());
    }

    #[Test]
    public function testRoutesStreamingRequestToStreamingTransporter(): void
    {
        [$client, $plain, $streaming] = $this->buildClient();

        $client->request('GET', '/', headers: ['Accept' => 'text/event-stream']);

        $this->assertCount(0, $plain->getRequests());
        $this->assertCount(1, $streaming->getRequests());

        $sent = $streaming->getRequests()[0];
        $this->assertStringContainsString('text/event-stream', $sent->getHeaderLine('Accept'));
    }

    /**
     * @return array{BaseClient, MockClient, MockClient}
     */
    private function buildClient(): array
    {
        $plain = new MockClient;
        $plain->setDefaultResponse($this->jsonResponse());

        $streaming = new MockClient;
        $streaming->setDefaultResponse($this->sseResponse());

        $options = RequestOptions::with(
            transporter: $plain,
            streamingTransporter: $streaming,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );

        $client = new class(headers: [], baseUrl: 'http://localhost', options: $options) extends BaseClient {};

        return [$client, $plain, $streaming];
    }

    private function jsonResponse(): ResponseInterface
    {
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        return $responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream('{}'))
        ;
    }

    private function sseResponse(): ResponseInterface
    {
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        return $responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody($streamFactory->createStream(''))
        ;
    }
}
