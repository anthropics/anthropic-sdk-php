<?php

namespace Tests\Bedrock;

use Anthropic\Bedrock\Client;
use Anthropic\Core\Util;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
#[CoversNothing]
final class ClientTest extends TestCase
{
    private MockClient $transporter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;

        $mockResponse = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->setDefaultResponse($mockResponse);
    }

    public function testApiKeyAuthWithExplicitFactory(): void
    {
        $client = Client::withApiKey(
            apiKey: 'test-bedrock-api-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello', 'role' => 'user']],
            model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
        );

        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('x-api-key'));
        $this->assertSame('Bearer test-bedrock-api-key', $request->getHeaderLine('authorization'));
        $this->assertSame('', $request->getHeaderLine('x-amz-date'));
        $this->assertSame('bedrock-runtime.us-east-1.amazonaws.com', $request->getUri()->getHost());
        $this->assertSame('/model/anthropic.claude-3-5-sonnet-20241022-v2%3A0/invoke', $request->getUri()->getPath());

        $body = json_decode((string) $request->getBody(), associative: true, flags: JSON_THROW_ON_ERROR);

        $this->assertIsArray($body);

        $this->assertSame('bedrock-2023-05-31', $body['anthropic_version']);
        $this->assertSame(1024, $body['max_tokens']);
        $this->assertSame([['content' => 'Hello', 'role' => 'user']], $body['messages']);
        $this->assertArrayNotHasKey('model', $body);
        $this->assertArrayNotHasKey('stream', $body);
    }

    public function testApiKeyAuthFromEnvironment(): void
    {
        $originalApiKey = Util::getenv('AWS_BEARER_TOKEN_BEDROCK');

        putenv('AWS_BEARER_TOKEN_BEDROCK=test-bedrock-api-key-from-env');

        try {
            $client = Client::fromEnvironment(
                region: 'us-east-2',
                requestOptions: ['transporter' => $this->transporter],
            );

            $client->messages->create(
                maxTokens: 1024,
                messages: [['content' => 'Hello', 'role' => 'user']],
                model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
            );

            $request = $this->getLastRequest();

            $this->assertSame('Bearer test-bedrock-api-key-from-env', $request->getHeaderLine('authorization'));
            $this->assertSame('bedrock-runtime.us-east-2.amazonaws.com', $request->getUri()->getHost());
        } finally {
            if (null !== $originalApiKey) {
                putenv('AWS_BEARER_TOKEN_BEDROCK='.$originalApiKey);
            } else {
                putenv('AWS_BEARER_TOKEN_BEDROCK');
            }
        }
    }

    public function testWithCredentialsStillSignsRequests(): void
    {
        $client = Client::withCredentials(
            accessKeyId: 'test-access-key',
            secretAccessKey: 'test-secret-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello', 'role' => 'user']],
            model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
        );

        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('x-api-key'));
        $this->assertStringContainsString('AWS4-HMAC-SHA256', $request->getHeaderLine('authorization'));
        $this->assertNotSame('', $request->getHeaderLine('x-amz-date'));
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
