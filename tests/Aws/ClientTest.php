<?php

namespace Tests\Aws;

use Anthropic\Aws\Client;
use Anthropic\Core\Exceptions\AnthropicException;
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
class ClientTest extends TestCase
{
    private MockClient $transporter;

    /** @var array<string,string|null> */
    private array $savedEnv = [];

    private const ENV_KEYS = [
        'AWS_REGION',
        'AWS_DEFAULT_REGION',
        'ANTHROPIC_AWS_WORKSPACE_ID',
        'ANTHROPIC_AWS_BASE_URL',
        'ANTHROPIC_AWS_API_KEY',
        'ANTHROPIC_API_KEY',
    ];

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
            if ($value === null) {
                putenv($key);
            } else {
                putenv("{$key}={$value}");
            }
        }
    }

    // ── Validation ──────────────────────────────────────────────────

    public function testMissingWorkspaceIdThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('workspace ID');

        new Client(
            apiKey: 'key',
            awsRegion: 'us-east-1',
        );
    }

    public function testMissingRegionAndBaseUrlThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('base URL or region');

        new Client(
            apiKey: 'key',
            workspaceId: 'default',
        );
    }

    public function testMissingRegionForSigV4Throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('region');

        new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            workspaceId: 'default',
            baseUrl: 'https://example.com',
        );
    }

    // ── API key mode ────────────────────────────────────────────────

    public function testApiKeyAuthSendsCorrectHeaders(): void
    {
        $client = $this->makeClient(apiKey: 'my-aws-key');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('my-aws-key', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('default', $request->getHeaderLine('anthropic-workspace-id'));
        $this->assertSame('', $request->getHeaderLine('Authorization'));
    }

    public function testApiKeyFromEnvVar(): void
    {
        putenv('ANTHROPIC_AWS_API_KEY=env-key');

        $client = new Client(
            awsRegion: 'us-east-1',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('env-key', $request->getHeaderLine('X-Api-Key'));
    }

    public function testExplicitApiKeyOverridesEnvVar(): void
    {
        putenv('ANTHROPIC_AWS_API_KEY=env-key');

        $client = $this->makeClient(apiKey: 'explicit-key');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('explicit-key', $request->getHeaderLine('X-Api-Key'));
    }

    // ── SigV4 mode ──────────────────────────────────────────────────

    public function testSigV4WithExplicitCredentialsSigns(): void
    {
        $client = new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertStringContainsString('AWS4-HMAC-SHA256', $request->getHeaderLine('Authorization'));
        $this->assertStringContainsString('aws-external-anthropic', $request->getHeaderLine('Authorization'));
        $this->assertNotEmpty($request->getHeaderLine('X-Amz-Date'));
        $this->assertSame('default', $request->getHeaderLine('anthropic-workspace-id'));
        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
    }

    public function testSigV4WithSessionToken(): void
    {
        $client = new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsSessionToken: 'session-token',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('session-token', $request->getHeaderLine('X-Amz-Security-Token'));
    }

    public function testSigV4CredentialsNotSentOnCrossOriginRedirect(): void
    {
        $client = new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsSessionToken: 'session-token',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
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
        putenv('ANTHROPIC_AWS_API_KEY=env-key');

        $client = new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
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
        $client = new Client(
            awsRegion: 'us-east-1',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('', $request->getHeaderLine('Authorization'));
        $this->assertSame('', $request->getHeaderLine('X-Amz-Date'));
        $this->assertSame('', $request->getHeaderLine('anthropic-workspace-id'));
    }

    public function testSkipAuthDoesNotRequireWorkspaceId(): void
    {
        // Should not throw — workspace ID is optional when skipAuth is true
        $client = new Client(
            awsRegion: 'us-east-1',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->addToAssertionCount(1);
    }

    // ── Region resolution ───────────────────────────────────────────

    public function testRegionFromAwsRegionEnv(): void
    {
        putenv('AWS_REGION=eu-west-1');

        $client = new Client(
            apiKey: 'key',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-external-anthropic.eu-west-1.api.aws', $request->getUri()->getHost());
    }

    public function testRegionFromAwsDefaultRegionEnv(): void
    {
        putenv('AWS_DEFAULT_REGION=ap-southeast-1');

        $client = new Client(
            apiKey: 'key',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-external-anthropic.ap-southeast-1.api.aws', $request->getUri()->getHost());
    }

    public function testAwsRegionEnvTakesPrecedenceOverDefault(): void
    {
        putenv('AWS_REGION=us-east-1');
        putenv('AWS_DEFAULT_REGION=eu-west-1');

        $client = new Client(
            apiKey: 'key',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-external-anthropic.us-east-1.api.aws', $request->getUri()->getHost());
    }

    public function testExplicitRegionOverridesEnv(): void
    {
        putenv('AWS_REGION=eu-west-1');

        $client = new Client(
            apiKey: 'key',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-external-anthropic.us-west-2.api.aws', $request->getUri()->getHost());
    }

    // ── Base URL resolution ─────────────────────────────────────────

    public function testBaseUrlDerivedFromRegion(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('aws-external-anthropic.us-east-1.api.aws', $request->getUri()->getHost());
    }

    public function testExplicitBaseUrlOverridesRegion(): void
    {
        $client = new Client(
            apiKey: 'key',
            awsRegion: 'us-east-1',
            workspaceId: 'default',
            baseUrl: 'https://custom.example.com',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('custom.example.com', $request->getUri()->getHost());
    }

    public function testBaseUrlFromEnvVar(): void
    {
        putenv('ANTHROPIC_AWS_BASE_URL=https://env.example.com');

        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('env.example.com', $request->getUri()->getHost());
    }

    public function testWorkspaceIdFromEnvVar(): void
    {
        putenv('ANTHROPIC_AWS_WORKSPACE_ID=env-workspace');

        $client = new Client(
            apiKey: 'key',
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('env-workspace', $request->getHeaderLine('anthropic-workspace-id'));
    }

    // ── Per-request workspace-id overrides the client value ─────────

    public function testPerRequestExtraHeadersOverrideWorkspaceId(): void
    {
        $client = $this->makeClient();

        $client->messages->create(
            1024,
            [],
            'claude-haiku-4-5',
            requestOptions: ['extraHeaders' => ['anthropic-workspace-id' => 'per-request']],
        );
        $request = $this->getLastRequest();

        $this->assertSame(['per-request'], $request->getHeader('anthropic-workspace-id'));
    }

    public function testPerRequestWorkspaceIdParamOverridesClientWorkspaceId(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5', workspaceID: 'per-request');
        $request = $this->getLastRequest();

        $this->assertSame(['per-request'], $request->getHeader('anthropic-workspace-id'));
    }

    public function testClientWorkspaceIdSentWhenNoPerRequestValue(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame(['default'], $request->getHeader('anthropic-workspace-id'));
    }

    // ── API key env var doesn't leak into SigV4 ─────────────────────

    public function testAnthropicApiKeyEnvDoesNotLeak(): void
    {
        putenv('ANTHROPIC_API_KEY=leaked-key');

        $client = new Client(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
    }

    // ── Resources exist ─────────────────────────────────────────────

    public function testResourcesExist(): void
    {
        $client = $this->makeClient();

        // Smoke test: AWS client inherits all resources from the base client
        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $this->addToAssertionCount(1);
    }

    // ── User profiles ───────────────────────────────────────────────

    /**
     * @param \Closure(Client): mixed $call
     * @param array<string, mixed>|null $body
     */
    #[DataProvider('userProfilesCalls')]
    public function testUserProfilesRequestsGoToTheGatewayWithItsAuthAndWorkspace(\Closure $call, string $method, string $path, ?array $body): void
    {
        $call($this->makeClient(apiKey: 'my-aws-key'));
        $request = $this->getLastRequest();

        $this->assertSame($method, $request->getMethod());
        $this->assertSame('https://aws-external-anthropic.us-east-1.api.aws'.$path, (string) $request->getUri());
        $this->assertSame('my-aws-key', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('default', $request->getHeaderLine('anthropic-workspace-id'));
        $this->assertSame($body, json_decode((string) $request->getBody(), associative: true));
    }

    /**
     * @return iterable<string, array{\Closure(Client): mixed, string, string, array<string, mixed>|null}>
     */
    public static function userProfilesCalls(): iterable
    {
        yield 'create' => [
            static fn (Client $client) => $client->userProfiles->create(name: 'Example'),
            'POST',
            '/v1/user_profiles',
            ['name' => 'Example'],
        ];

        yield 'retrieve' => [
            static fn (Client $client) => $client->userProfiles->retrieve('uprof_1'),
            'GET',
            '/v1/user_profiles/uprof_1',
            null,
        ];

        yield 'update' => [
            static fn (Client $client) => $client->userProfiles->update('uprof_1', name: 'Example'),
            'POST',
            '/v1/user_profiles/uprof_1',
            ['name' => 'Example'],
        ];

        yield 'list' => [
            static fn (Client $client) => $client->userProfiles->list(limit: 2),
            'GET',
            '/v1/user_profiles?limit=2',
            null,
        ];

        yield 'delete' => [
            static fn (Client $client) => $client->userProfiles->delete('uprof_1'),
            'DELETE',
            '/v1/user_profiles/uprof_1',
            null,
        ];
    }

    public function testUserProfileRequestsAreSignedWithSigV4(): void
    {
        $client = new Client(
            awsAccessKey: 'AKIAIOSFODNN7EXAMPLE',
            awsSecretAccessKey: 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY',
            awsRegion: 'us-east-1',
            workspaceId: 'default',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->userProfiles->delete('uprof_1');
        $request = $this->getLastRequest();

        $this->assertStringStartsWith('AWS4-HMAC-SHA256', $request->getHeaderLine('Authorization'));
        $this->assertSame('default', $request->getHeaderLine('anthropic-workspace-id'));
    }

    /**
     * @param \Closure(Client, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdIsSentAsAHeaderAndNotInTheBody(\Closure $call): void
    {
        $call($this->makeClient(), 'uprof_123');
        $request = $this->getLastRequest();

        $this->assertSame('uprof_123', $request->getHeaderLine('anthropic-user-profile-id'));
        $body = json_decode((string) $request->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertArrayNotHasKey('user_profile_id', $body);
        $this->assertArrayNotHasKey('userProfileID', $body);
    }

    /**
     * @param \Closure(Client, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdHeaderIsOmittedWhenNotGiven(\Closure $call): void
    {
        $call($this->makeClient(), null);

        $this->assertFalse($this->getLastRequest()->hasHeader('anthropic-user-profile-id'));
    }

    /**
     * @return iterable<string, array{\Closure(Client, string|null): mixed}>
     */
    public static function messagesCalls(): iterable
    {
        yield 'create' => [static fn (Client $client, ?string $id) => $client->messages->create(
            maxTokens: 1024,
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $id,
        )];

        yield 'countTokens' => [static fn (Client $client, ?string $id) => $client->messages->countTokens(
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $id,
        )];
    }

    /**
     * @param \Closure(Client): mixed $call
     */
    #[DataProvider('actionURLsCalls')]
    public function testUserProfileActionUrlsThrowBeforeAnyRequestIsSent(\Closure $call): void
    {
        try {
            $call($this->makeClient());
            $this->fail('expected action URLs to be refused on the AWS gateway');
        } catch (AnthropicException $e) {
            $this->assertStringContainsString('action URLs are not available via the AWS gateway', $e->getMessage());
            $this->assertStringContainsString('Anthropic\Client', $e->getMessage());
        }

        $this->assertSame([], $this->transporter->getRequests());
    }

    /**
     * @return iterable<string, array{\Closure(Client): mixed}>
     */
    public static function actionURLsCalls(): iterable
    {
        yield 'userProfiles' => [
            static fn (Client $client) => $client->userProfiles->actionURLs->create('uprof_1', action: ['type' => 'enroll_end_user']),
        ];

        yield 'beta userProfiles' => [
            static fn (Client $client) => $client->beta->userProfiles->actionURLs->create('uprof_1', action: ['type' => 'enroll_end_user']),
        ];
    }

    // ── Helpers ─────────────────────────────────────────────────────

    private function makeClient(?string $apiKey = null): Client
    {
        return new Client(
            apiKey: $apiKey ?? 'test-key',
            awsRegion: 'us-east-1',
            workspaceId: 'default',
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
