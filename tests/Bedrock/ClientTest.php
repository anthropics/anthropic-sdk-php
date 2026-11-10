<?php

namespace Tests\Bedrock;

use Anthropic\Bedrock\Client;
use Anthropic\Core\Util;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
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
        $this->assertSame('/model/anthropic.claude-3-5-sonnet-20241022-v2:0/invoke', $request->getUri()->getPath());

        $body = json_decode((string) $request->getBody(), associative: true, flags: JSON_THROW_ON_ERROR);

        $this->assertIsArray($body);

        $this->assertSame(\Anthropic\Client::ANTHROPIC_API_VERSION, $body['anthropic_version']);
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

    public function testAnthropicCredentialEnvDoesNotLeak(): void
    {
        $names = ['ANTHROPIC_API_KEY', 'ANTHROPIC_AUTH_TOKEN'];
        $original = array_map(Util::getenv(...), array_combine($names, $names));
        putenv('ANTHROPIC_API_KEY=leaked-key');
        putenv('ANTHROPIC_AUTH_TOKEN=leaked-token');

        try {
            $client = Client::withCredentials(accessKeyId: 'test-access-key', secretAccessKey: 'test-secret-key', region: 'us-east-1');
        } finally {
            foreach ($original as $name => $value) {
                putenv(is_null($value) ? $name : "{$name}={$value}");
            }
        }

        $this->assertSame('', $client->apiKey);
        $this->assertSame('', $client->authToken);
    }

    public function testSigV4CredentialsNotSentOnCrossOriginRedirect(): void
    {
        $client = Client::withCredentials(
            accessKeyId: 'test-access-key',
            secretAccessKey: 'test-secret-key',
            region: 'us-east-1',
            securityToken: 'session-token',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(307)
                ->withHeader('Location', 'https://elsewhere.example/invoke')
        );

        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello', 'role' => 'user']],
            model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
        );

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('session-token', $requests[0]->getHeaderLine('X-Amz-Security-Token'));
        $this->assertSame('elsewhere.example', $requests[1]->getUri()->getHost());
        $this->assertFalse($requests[1]->hasHeader('Authorization'));
        $this->assertFalse($requests[1]->hasHeader('X-Amz-Security-Token'));
    }

    public function testExtraQueryParamsKeepGeneratedEncoding(): void
    {
        $client = Client::withApiKey(
            apiKey: 'test-bedrock-api-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $query = ['ids' => ['a', 'b c']];
        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello', 'role' => 'user']],
            model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
            requestOptions: ['extraQueryParams' => $query],
        );

        $request = $this->getLastRequest();
        $expected = Util::joinUri(Psr17FactoryDiscovery::findUriFactory()->createUri(), path: '', query: $query)->getQuery();

        $this->assertSame('/model/anthropic.claude-3-5-sonnet-20241022-v2:0/invoke', $request->getUri()->getPath());
        $this->assertSame($expected, $request->getUri()->getQuery());
    }

    public function testInferenceProfileArnIsSentAsOnePathSegment(): void
    {
        $client = Client::withApiKey(
            apiKey: 'test-bedrock-api-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello', 'role' => 'user']],
            model: 'arn:aws:bedrock:us-east-1:123456789012:inference-profile/us.anthropic.claude-sonnet-4-20250514-v1:0',
        );

        $this->assertSame(
            '/model/arn:aws:bedrock:us-east-1:123456789012:inference-profile%2Fus.anthropic.claude-sonnet-4-20250514-v1:0/invoke',
            $this->getLastRequest()->getUri()->getPath(),
        );
    }

    /**
     * @param \Closure(Client, string): mixed $call
     */
    #[DataProvider('refusedModelCalls')]
    public function testModelThatIsEmptyOrADotSegmentBeforeItsSemicolonThrowsBeforeAnyRequestIsSent(\Closure $call, string $model, string $message): void
    {
        $client = Client::withApiKey(
            apiKey: 'test-bedrock-api-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        try {
            $call($client, $model);
            $this->fail("expected the model \"{$model}\" to be refused");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString($message, $e->getMessage());
        }

        $this->assertSame([], $this->transporter->getRequests());
    }

    /**
     * @return iterable<string, array{\Closure(Client, string): mixed, string, string}>
     */
    public static function refusedModelCalls(): iterable
    {
        $messages = array_fill_keys(['', ';', ';x', ';a=b', ';..'], 'non-empty string `model`');
        foreach (['.', '..', '.;x', '..;x', '..;', '.;a=b'] as $model) {
            $messages[$model] = "dot segment \"{$model}\"";
        }

        foreach ($messages as $model => $message) {
            yield "create with \"{$model}\"" => [
                static fn (Client $client, string $model) => $client->messages->create(maxTokens: 1024, messages: [], model: $model),
                $model,
                $message,
            ];

            yield "createStream with \"{$model}\"" => [
                static fn (Client $client, string $model) => $client->messages->createStream(maxTokens: 1024, messages: [], model: $model),
                $model,
                $message,
            ];

            yield "countTokens with \"{$model}\"" => [
                static fn (Client $client, string $model) => $client->messages->countTokens(messages: [], model: $model),
                $model,
                $message,
            ];
        }
    }

    #[DataProvider('sentModelsWithSemicolon')]
    public function testAnyOtherModelWithSemicolonIsSentAsOnePathSegment(string $model, string $path): void
    {
        $client = Client::withApiKey(
            apiKey: 'test-bedrock-api-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(maxTokens: 1024, messages: [], model: $model);
        $this->assertSame("{$path}/invoke", $this->getLastRequest()->getUri()->getPath());

        $client->messages->countTokens(messages: [], model: $model);
        $this->assertSame("{$path}/count-tokens", $this->getLastRequest()->getUri()->getPath());
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function sentModelsWithSemicolon(): iterable
    {
        yield 'a;b' => ['a;b', '/model/a;b'];

        yield '...;x' => ['...;x', '/model/...;x'];

        yield '..x;y' => ['..x;y', '/model/..x;y'];

        yield 'x;..' => ['x;..', '/model/x;..'];

        yield 'a;b/c' => ['a;b/c', '/model/a;b%2Fc'];
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
