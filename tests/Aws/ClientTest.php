<?php

namespace Tests\Aws;

use Anthropic\Aws\Client;
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

    // ── Workspace-id header not overridable ─────────────────────────

    public function testWorkspaceIdNotOverridableByExtraHeaders(): void
    {
        $client = new Client(
            apiKey: 'key',
            awsRegion: 'us-east-1',
            workspaceId: 'default',
            requestOptions: [
                'transporter' => $this->transporter,
                'extraHeaders' => ['anthropic-workspace-id' => 'override-attempt'],
            ],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('default', $request->getHeaderLine('anthropic-workspace-id'));
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
