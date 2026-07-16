<?php

namespace Tests\GoogleCloud;

use Anthropic\Core\Util;
use Anthropic\GoogleCloud\Client;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\ProjectIdProviderInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @coversNothing
 */
final class ClientTest extends TestCase
{
    private const ENV_KEYS = [
        'ANTHROPIC_GOOGLE_CLOUD_PROJECT',
        'ANTHROPIC_GOOGLE_CLOUD_LOCATION',
        'ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID',
        'ANTHROPIC_GOOGLE_CLOUD_BASE_URL',
        'GOOGLE_CLOUD_PROJECT',
        'ANTHROPIC_API_KEY',
        'ANTHROPIC_AUTH_TOKEN',
        'ANTHROPIC_BASE_URL',
    ];
    private MockClient $transporter;

    /** @var array<string,string|null> */
    private array $savedEnv = [];

    protected function setUp(): void
    {
        $this->transporter = new MockClient;
        $this->transporter->setDefaultResponse($this->jsonResponse());

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

    public function testMissingWorkspaceIdThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID');

        new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
        );
    }

    public function testMissingProjectThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ANTHROPIC_GOOGLE_CLOUD_PROJECT');

        new Client(
            location: 'us-east5',
            workspaceId: 'ws',
            tokenProvider: fn () => 'tok',
        );
    }

    public function testLocationDefaultsToGlobal(): void
    {
        $client = new Client(
            project: 'proj',
            workspaceId: 'ws',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/locations/global/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testSkipAuthMutuallyExclusiveWithCredentials(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('mutually exclusive');

        new Client(
            baseUrl: 'https://example.com',
            tokenProvider: fn () => 'tok',
            skipAuth: true,
        );
    }

    // ── Credential isolation ────────────────────────────────────────

    public function testAnthropicApiKeyEnvDoesNotLeak(): void
    {
        putenv('ANTHROPIC_API_KEY=leaked-key');
        putenv('ANTHROPIC_AUTH_TOKEN=leaked-token');
        putenv('ANTHROPIC_BASE_URL=https://leaked.example.com');

        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('Bearer adc-token', $request->getHeaderLine('Authorization'));
        $this->assertSame('claude.googleapis.com', $request->getUri()->getHost());
        $this->assertSame('', $client->apiKey);
    }

    // ── Credentials precedence ──────────────────────────────────────

    public function testTokenProviderWinsOverGoogleCredentials(): void
    {
        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            workspaceId: 'ws',
            googleCredentials: $this->stubCredentials('creds-token'),
            tokenProvider: fn () => 'provider-token',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('Bearer provider-token', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testExplicitGoogleCredentialsUsed(): void
    {
        $client = $this->makeClient(googleCredentials: $this->stubCredentials('explicit-token'));

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('Bearer explicit-token', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testTokenIsCachedUntilNearExpiry(): void
    {
        $calls = 0;
        $creds = $this->createMock(FetchAuthTokenInterface::class);
        $creds->method('fetchAuthToken')->willReturnCallback(function () use (&$calls) {
            ++$calls;

            return ['access_token' => "tok-{$calls}", 'expires_at' => time() + 3600];
        });

        $client = $this->makeClient(googleCredentials: $creds);

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame(1, $calls);
        $this->assertSame('Bearer tok-1', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testTokenRefreshedWhenExpiringWithinBuffer(): void
    {
        $calls = 0;
        $creds = $this->createMock(FetchAuthTokenInterface::class);
        $creds->method('fetchAuthToken')->willReturnCallback(function () use (&$calls) {
            ++$calls;

            return ['access_token' => "tok-{$calls}", 'expires_at' => time() + 60];
        });

        $client = $this->makeClient(googleCredentials: $creds);

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame(2, $calls);
        $this->assertSame('Bearer tok-2', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    // ── Project precedence ──────────────────────────────────────────

    public function testProjectFromEnvVar(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_PROJECT=env-proj');

        $client = $this->makeClient(project: null);

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/projects/env-proj/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testProjectArgOverridesEnv(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_PROJECT=env-proj');

        $client = $this->makeClient(project: 'arg-proj');

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/projects/arg-proj/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testProjectFromGoogleCloudProjectFallback(): void
    {
        putenv('GOOGLE_CLOUD_PROJECT=gcp-proj');

        $client = $this->makeClient(project: null);

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/projects/gcp-proj/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testAnthropicProjectEnvWinsOverGoogleCloudProject(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_PROJECT=ours');
        putenv('GOOGLE_CLOUD_PROJECT=theirs');

        $client = $this->makeClient(project: null);

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/projects/ours/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testProjectFromCredentials(): void
    {
        $creds = $this->createMockForIntersectionOfInterfaces([
            FetchAuthTokenInterface::class,
            ProjectIdProviderInterface::class,
        ]);
        $creds->method('fetchAuthToken')->willReturn(['access_token' => 'adc-token']);
        $creds->method('getProjectId')->willReturn('creds-proj');

        $client = new Client(
            location: 'us-east5',
            workspaceId: 'ws',
            googleCredentials: $creds,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/projects/creds-proj/', $this->getLastRequest()->getUri()->getPath());
    }

    // ── Location precedence ─────────────────────────────────────────

    public function testLocationFromEnvVar(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_LOCATION=europe-west4');

        $client = $this->makeClient(location: null);

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/locations/europe-west4/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testLocationArgOverridesEnv(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_LOCATION=europe-west4');

        $client = $this->makeClient(location: 'us-east5');

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/locations/us-east5/', $this->getLastRequest()->getUri()->getPath());
    }

    // ── Base URL precedence ─────────────────────────────────────────

    public function testBaseUrlDerived(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $uri = $this->getLastRequest()->getUri();

        $this->assertSame('claude.googleapis.com', $uri->getHost());
        $this->assertSame(
            '/v1alpha/projects/proj/locations/us-east5/workspaces/ws/invoke/v1/messages',
            $uri->getPath()
        );
    }

    public function testBaseUrlFromEnvVar(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_BASE_URL=https://env.example.com');

        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('env.example.com', $this->getLastRequest()->getUri()->getHost());
    }

    public function testExplicitBaseUrlOverridesEnvAndDerivation(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_BASE_URL=https://env.example.com');

        $client = new Client(
            workspaceId: 'ws',
            baseUrl: 'https://custom.example.com',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('custom.example.com', $this->getLastRequest()->getUri()->getHost());
    }

    public function testExplicitBaseUrlDoesNotRequireProjectOrLocation(): void
    {
        $client = new Client(
            workspaceId: 'ws',
            baseUrl: 'https://custom.example.com',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->addToAssertionCount(1);
    }

    // ── Workspace id (URL path only) ────────────────────────────────

    public function testWorkspaceIdFromEnvVar(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID=env-ws');

        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/workspaces/env-ws/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testWorkspaceIdArgOverridesEnv(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID=env-ws');

        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertStringContainsString('/workspaces/ws/', $this->getLastRequest()->getUri()->getPath());
    }

    public function testWorkspaceIdHeaderNotSent(): void
    {
        // The gateway resolves the workspace from the URL path and mints the
        // header itself — the client must not send it.
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('', $this->getLastRequest()->getHeaderLine('anthropic-workspace-id'));
    }

    // ── Default headers ─────────────────────────────────────────────

    public function testAnthropicVersionHeaderSent(): void
    {
        $client = $this->makeClient();

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame('2023-06-01', $this->getLastRequest()->getHeaderLine('anthropic-version'));
    }

    // ── skipAuth ────────────────────────────────────────────────────

    public function testSkipAuthNoHeaders(): void
    {
        $client = new Client(
            baseUrl: 'https://example.com',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('', $request->getHeaderLine('Authorization'));
        $this->assertSame('', $request->getHeaderLine('X-Api-Key'));
        $this->assertSame('', $request->getHeaderLine('anthropic-workspace-id'));
    }

    public function testSkipAuthWithExplicitBaseUrlDoesNotRequireWorkspaceId(): void
    {
        new Client(
            baseUrl: 'https://example.com',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->addToAssertionCount(1);
    }

    public function testSkipAuthWithoutBaseUrlRequiresWorkspaceId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID');

        new Client(
            project: 'proj',
            location: 'us-east5',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    public function testSkipAuthDerivesBaseUrlWithWorkspaceId(): void
    {
        $client = new Client(
            project: 'proj',
            workspaceId: 'ws',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $uri = $this->getLastRequest()->getUri();

        $this->assertSame('claude.googleapis.com', $uri->getHost());
        $this->assertSame(
            '/v1alpha/projects/proj/locations/global/workspaces/ws/invoke/v1/messages',
            $uri->getPath()
        );
    }

    // ── Cross-origin redirect ───────────────────────────────────────

    public function testBearerNotSentOnCrossOriginRedirect(): void
    {
        // BaseClient::followRedirect() does not strip Authorization on a
        // cross-host redirect, and transformRequest() re-applies it on the
        // redirected hop — same gap as Aws\Client. Tracked as a Core
        // follow-up; unskip once followRedirect() drops auth on host change.
        $this->markTestSkipped('Core followRedirect() does not yet strip auth on cross-host redirect (shared with Aws\Client)');
    }

    // ── Surface ─────────────────────────────────────────────────────

    public function testResourcesExist(): void
    {
        $client = $this->makeClient();

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $client->beta->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertCount(2, $this->transporter->getRequests());
    }

    // ── Helpers ─────────────────────────────────────────────────────

    private function makeClient(
        ?string $project = 'proj',
        ?string $location = 'us-east5',
        ?FetchAuthTokenInterface $googleCredentials = null,
    ): Client {
        return new Client(
            project: $project,
            location: $location,
            workspaceId: 'ws',
            googleCredentials: $googleCredentials ?? $this->stubCredentials('adc-token'),
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    private function jsonResponse(): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;
    }

    private function stubCredentials(string $token): FetchAuthTokenInterface
    {
        $creds = $this->createMock(FetchAuthTokenInterface::class);
        $creds->method('fetchAuthToken')->willReturn(['access_token' => $token]);

        return $creds;
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
