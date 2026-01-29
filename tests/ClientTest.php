<?php

namespace Tests;

use Anthropic\Client;
use Anthropic\Core\Util;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientTest extends TestCase
{
    private MockClient $transporter;

    protected function setUp(): void
    {
        $this->transporter = new MockClient;

        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->setDefaultResponse($mockRsp);
    }

    public function testApiKeyAuth(): void
    {
        $client = new Client(
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        $this->assertSame('my-anthropic-api-key', $request->getHeaderLine('x-api-key'));
    }

    public function testAuthTokenAuth(): void
    {
        $client = new Client(
            authToken: 'my-anthropic-auth-token',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        $this->assertSame('Bearer my-anthropic-auth-token', $request->getHeaderLine('Authorization'));
    }

    public function testDefaultBaseUrl(): void
    {
        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        $this->assertSame('api.anthropic.com', $request->getUri()->getHost());
    }

    public function testCustomBaseUrlInConstructor(): void
    {
        $client = new Client(
            baseUrl: 'https://example.com',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        $this->assertSame('example.com', $request->getUri()->getHost());
    }

    public function testCustomBaseUrlAsEnvironmentVariable(): void
    {
        $originalBaseUrl = getenv('ANTHROPIC_BASE_URL');
        putenv('ANTHROPIC_BASE_URL=https://example.com');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        try {
            $this->assertSame('example.com', $request->getUri()->getHost());
        } finally {
            if (false !== $originalBaseUrl) {
                putenv('ANTHROPIC_BASE_URL='.$originalBaseUrl);
            } else {
                putenv('ANTHROPIC_BASE_URL');
            }
        }
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
