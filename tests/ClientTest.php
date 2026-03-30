<?php

namespace Tests;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;
use Anthropic\ErrorType;
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

        $client->messages->create(1024, [], 'claude-opus-4-6');

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
        $originalBaseUrl = Util::getenv('ANTHROPIC_BASE_URL');
        putenv('ANTHROPIC_BASE_URL=https://example.com');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $request = $this->getLastRequest();

        try {
            $this->assertSame('example.com', $request->getUri()->getHost());
        } finally {
            if ($originalBaseUrl) {
                putenv('ANTHROPIC_BASE_URL='.$originalBaseUrl);
            } else {
                putenv('ANTHROPIC_BASE_URL');
            }
        }
    }

    public function testStatusErrorTypeField(): void
    {
        $e = $this->makeErrorRequest([
            'type' => 'error',
            'error' => ['type' => 'invalid_request_error', 'message' => 'Bad request'],
        ]);

        $this->assertInstanceOf(BadRequestException::class, $e);
        $this->assertSame(400, $e->status);
        $this->assertSame(ErrorType::INVALID_REQUEST_ERROR, $e->type);
    }

    public function testStatusErrorTypeFieldAbsent(): void
    {
        $e = $this->makeErrorRequest(['message' => 'Bad request']);

        $this->assertSame(400, $e->status);
        $this->assertNull($e->type);
    }

    /**
     * @param array<mixed> $body
     */
    private function makeErrorRequest(array $body, int $status = 400): APIStatusException
    {
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->setDefaultResponse($mockRsp);

        $client = new Client(
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $this->transporter],
        );

        try {
            $client->messages->create(1024, [], 'claude-opus-4-6');
            $this->fail('Expected APIStatusException to be thrown');
        } catch (APIStatusException $e) {
            return $e;
        }
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
