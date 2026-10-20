<?php

namespace Tests\Bedrock;

use Anthropic\Bedrock\MantleClient;
use Anthropic\Core\Util;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
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

        $this->assertSame('Bearer my-mantle-key', $request->getHeaderLine('Authorization'));
        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
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

        $this->assertSame('Bearer mantle-env-key', $request->getHeaderLine('Authorization'));
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

        $this->assertSame('Bearer aws-fallback-key', $request->getHeaderLine('Authorization'));
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

        $this->assertSame('Bearer mantle-key', $request->getHeaderLine('Authorization'));
    }

    public function testExplicitApiKeyOverridesAllEnvVars(): void
    {
        putenv('AWS_BEARER_TOKEN_BEDROCK=mantle-env');
        putenv('ANTHROPIC_AWS_API_KEY=aws-env');

        $client = $this->makeClient(apiKey: 'explicit-key');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('Bearer explicit-key', $request->getHeaderLine('Authorization'));
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

    public function testSigV4CredentialsNotSentOnCrossOriginRedirect(): void
    {
        $client = new MantleClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsSessionToken: 'session-token',
            awsRegion: 'us-west-2',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(307)
                ->withHeader('Location', 'https://elsewhere.example/v1/messages')
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('session-token', $requests[0]->getHeaderLine('X-Amz-Security-Token'));
        $this->assertSame('elsewhere.example', $requests[1]->getUri()->getHost());
        $this->assertFalse($requests[1]->hasHeader('Authorization'));
        $this->assertFalse($requests[1]->hasHeader('X-Amz-Security-Token'));
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

        // models, user profiles and beta should NOT exist
        $this->assertFalse(property_exists($client, 'models'));
        $this->assertFalse(property_exists($client, 'userProfiles'));
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

    // ── Request body ────────────────────────────────────────────────

    public function testSpeedIsSentInRequestBody(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5', speed: 'fast');
        $request = $this->getLastRequest();

        $body = json_decode((string) $request->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertSame('fast', $body['speed']);
    }

    /**
     * @param \Closure(MantleClient, string|null, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdIsSentInRequestBodyAndNotAsHeader(\Closure $call, string $contentType): void
    {
        $this->respondWith($contentType);

        $call($this->makeClient(), 'uprof_123', null);
        $request = $this->getLastRequest();

        $body = json_decode((string) $request->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertSame('uprof_123', $body['user_profile_id'] ?? null);
        $this->assertArrayNotHasKey('userProfileID', $body);
        $this->assertFalse($request->hasHeader('anthropic-user-profile-id'));
    }

    /**
     * @param \Closure(MantleClient, string|null, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdFromExtraBodyParamsWins(\Closure $call, string $contentType): void
    {
        $this->respondWith($contentType);

        $call($this->makeClient(), 'uprof_123', 'uprof_extra');

        $body = json_decode((string) $this->getLastRequest()->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertSame('uprof_extra', $body['user_profile_id'] ?? null);
    }

    /**
     * @param \Closure(MantleClient, string|null, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdIsOmittedFromRequestBodyWhenNotGiven(\Closure $call, string $contentType): void
    {
        $this->respondWith($contentType);

        $call($this->makeClient(), null, null);

        $body = json_decode((string) $this->getLastRequest()->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertArrayNotHasKey('user_profile_id', $body);
    }

    /**
     * Each call takes the client, the `userProfileID` argument and a `user_profile_id` to pass in `extraBodyParams`.
     *
     * @return iterable<string, array{\Closure(MantleClient, string|null, string|null): mixed, string}>
     */
    public static function messagesCalls(): iterable
    {
        $params = static fn (?string $userProfileID): array => [
            'maxTokens' => 1024,
            'messages' => [],
            'model' => 'claude-haiku-4-5',
            ...(null === $userProfileID ? [] : ['userProfileID' => $userProfileID]),
        ];
        $options = static fn (?string $extra): ?array => null === $extra ? null : ['extraBodyParams' => ['user_profile_id' => $extra]];

        yield 'create' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->create(1024, [], 'claude-haiku-4-5', userProfileID: $userProfileID, requestOptions: $options($extra)),
            'application/json',
        ];

        yield 'createStream' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->createStream(1024, [], 'claude-haiku-4-5', userProfileID: $userProfileID, requestOptions: $options($extra)),
            'text/event-stream',
        ];

        yield 'raw create' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->raw->create($params($userProfileID), $options($extra)),
            'application/json',
        ];

        yield 'raw createStream' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->raw->createStream($params($userProfileID), $options($extra)),
            'text/event-stream',
        ];

        yield 'countTokens' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->countTokens([], 'claude-haiku-4-5', userProfileID: $userProfileID, requestOptions: $options($extra)),
            'application/json',
        ];

        yield 'raw countTokens' => [
            static fn (MantleClient $client, ?string $userProfileID, ?string $extra) => $client->messages->raw->countTokens(array_diff_key($params($userProfileID), ['maxTokens' => true]), $options($extra)),
            'application/json',
        ];
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

    private function respondWith(string $contentType): void
    {
        $this->transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', $contentType)
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('application/json' === $contentType ? '{}' : ''))
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
