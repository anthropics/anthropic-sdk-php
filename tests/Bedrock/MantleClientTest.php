<?php

namespace Tests\Bedrock;

use Anthropic\Bedrock\MantleClient;
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
class MantleClientTest extends TestCase
{
    private const ENV_KEYS = [
        'AWS_REGION',
        'AWS_DEFAULT_REGION',
        'AWS_BEARER_TOKEN_BEDROCK',
        'ANTHROPIC_BEDROCK_MANTLE_BASE_URL',
        'ANTHROPIC_AWS_API_KEY',
        'ANTHROPIC_API_KEY',
    ];
    private MockClient $transporter;

    /** @var array<string,string|null> */
    private array $savedEnv = [];

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

        foreach (self::ENV_KEYS as $key) {
            $this->savedEnv[$key] = Util::getenv($key);
            putenv($key);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->savedEnv as $key => $value) {
            if (null === $value) {
                putenv($key);
            } else {
                putenv("{$key}={$value}");
            }
        }
    }

    // ── Validation ──────────────────────────────────────────────────

    public function testMissingRegionAndBaseUrlThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('base URL or region');

        new MantleClient(
            apiKey: 'key',
        );
    }

    public function testMissingRegionForSigV4Throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('region');

        new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            baseUrl: 'https://example.com',
        );
    }

    // ── API key mode ────────────────────────────────────────────────

    public function testApiKeyAuthSendsCorrectHeaders(): void
    {
        $client = $this->makeClient(apiKey: 'my-mantle-key');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('my-mantle-key', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('', $request->getHeaderLine('Authorization'));
    }

    public function testApiKeyFromMantleEnvVar(): void
    {
        putenv('AWS_BEARER_TOKEN_BEDROCK=mantle-env-key');

        $client = new MantleClient(
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('mantle-env-key', $request->getHeaderLine('X-Api-Key'));
    }

    public function testApiKeyFallbackToAwsEnvVar(): void
    {
        putenv('ANTHROPIC_AWS_API_KEY=aws-fallback-key');

        $client = new MantleClient(
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-fallback-key', $request->getHeaderLine('X-Api-Key'));
    }

    public function testMantleApiKeyEnvTakesPrecedenceOverAwsFallback(): void
    {
        putenv('AWS_BEARER_TOKEN_BEDROCK=mantle-key');
        putenv('ANTHROPIC_AWS_API_KEY=aws-key');

        $client = new MantleClient(
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('mantle-key', $request->getHeaderLine('X-Api-Key'));
    }

    public function testExplicitApiKeyOverridesAllEnvVars(): void
    {
        putenv('AWS_BEARER_TOKEN_BEDROCK=mantle-env');
        putenv('ANTHROPIC_AWS_API_KEY=aws-env');

        $client = $this->makeClient(apiKey: 'explicit-key');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('explicit-key', $request->getHeaderLine('X-Api-Key'));
    }

    // ── SigV4 mode ──────────────────────────────────────────────────

    public function testSigV4WithExplicitCredentialsSigns(): void
    {
        $client = new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertStringContainsString('AWS4-HMAC-SHA256', $request->getHeaderLine('Authorization'));
        $this->assertStringContainsString('bedrock-mantle', $request->getHeaderLine('Authorization'));
        $this->assertNotEmpty($request->getHeaderLine('X-Amz-Date'));
        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
    }

    public function testSigV4WithSessionToken(): void
    {
        $client = new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsSessionToken: 'session-token',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('session-token', $request->getHeaderLine('X-Amz-Security-Token'));
    }

    public function testExplicitCredsOverrideEnvApiKey(): void
    {
        putenv('AWS_BEARER_TOKEN_BEDROCK=env-key');

        $client = new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
        $this->assertStringContainsString('AWS4-HMAC-SHA256', $request->getHeaderLine('Authorization'));
    }

    // ── skipAuth mode ───────────────────────────────────────────────

    public function testSkipAuthNoHeaders(): void
    {
        $client = new MantleClient(
            awsRegion: 'us-east-1',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('', $request->getHeaderLine('Authorization'));
        $this->assertSame('', $request->getHeaderLine('X-Amz-Date'));
    }

    // ── Region resolution ───────────────────────────────────────────

    public function testRegionFromAwsRegionEnv(): void
    {
        putenv('AWS_REGION=eu-west-1');

        $client = new MantleClient(
            apiKey: 'key',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('bedrock-mantle.eu-west-1.api.aws', $request->getUri()->getHost());
    }

    public function testRegionFromAwsDefaultRegionEnv(): void
    {
        putenv('AWS_DEFAULT_REGION=ap-southeast-1');

        $client = new MantleClient(
            apiKey: 'key',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('bedrock-mantle.ap-southeast-1.api.aws', $request->getUri()->getHost());
    }

    public function testAwsRegionEnvTakesPrecedenceOverDefault(): void
    {
        putenv('AWS_REGION=us-east-1');
        putenv('AWS_DEFAULT_REGION=eu-west-1');

        $client = new MantleClient(
            apiKey: 'key',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('bedrock-mantle.us-east-1.api.aws', $request->getUri()->getHost());
    }

    public function testExplicitRegionOverridesEnv(): void
    {
        putenv('AWS_REGION=eu-west-1');

        $client = new MantleClient(
            apiKey: 'key',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('bedrock-mantle.us-west-2.api.aws', $request->getUri()->getHost());
    }

    // ── Base URL resolution ─────────────────────────────────────────

    public function testBaseUrlDerivedFromRegion(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('bedrock-mantle.us-east-1.api.aws', $request->getUri()->getHost());
        $this->assertStringStartsWith('/anthropic/', $request->getUri()->getPath());
    }

    public function testExplicitBaseUrlOverridesRegion(): void
    {
        $client = new MantleClient(
            apiKey: 'key',
            awsRegion: 'us-east-1',
            baseUrl: 'https://custom.example.com',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('custom.example.com', $request->getUri()->getHost());
    }

    public function testBaseUrlFromMantleEnvVar(): void
    {
        putenv('ANTHROPIC_BEDROCK_MANTLE_BASE_URL=https://env-mantle.example.com');

        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('env-mantle.example.com', $request->getUri()->getHost());
    }

    // ── Resource restrictions ───────────────────────────────────────

    public function testOnlyMessagesResourceExists(): void
    {
        $client = $this->makeClient();

        // messages should exist and work
        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $this->addToAssertionCount(1);

        // models and beta should NOT exist
        $this->assertFalse(property_exists($client, 'models'));
        $this->assertFalse(property_exists($client, 'beta'));
    }

    // ── API key env var doesn't leak into SigV4 ─────────────────────

    public function testAnthropicApiKeyEnvDoesNotLeak(): void
    {
        putenv('ANTHROPIC_API_KEY=leaked-key');

        $client = new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
    }

    // ── Request path ────────────────────────────────────────────────

    public function testRequestPathIsCorrect(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('/anthropic/v1/messages', $request->getUri()->getPath());
    }

    // ── Helpers ─────────────────────────────────────────────────────

    private function makeClient(?string $apiKey = null): MantleClient
    {
        return new MantleClient(
            apiKey: $apiKey ?? 'test-key',
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
