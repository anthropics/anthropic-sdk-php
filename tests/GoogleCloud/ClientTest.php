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
    private const ORGANIZATION_BASE_URL = 'https://claude.googleapis.com/v1/projects/proj/locations/us-east5/claudeOrganization/invoke';
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

    public function testMissingWorkspaceIdDoesNotThrowAtConstruction(): void
    {
        new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
        );
        new Client(
            baseUrl: 'https://example.com',
            tokenProvider: fn () => 'tok',
        );

        $this->addToAssertionCount(2);
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
            '/v1/projects/proj/locations/us-east5/workspaces/ws/invoke/v1/messages',
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

    public function testSkipAuthWithoutBaseUrlRequiresWorkspaceIdForWorkspaceRoutes(): void
    {
        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            skipAuth: true,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->beta->organization->retrieve();
        $request = $this->getLastRequest();

        $this->assertSame(self::ORGANIZATION_BASE_URL.'/v1/organizations/me?beta=true', (string) $request->getUri());
        $this->assertSame('', $request->getHeaderLine('Authorization'));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID');

        $client->messages->create(1024, [], 'claude-haiku-4-5');
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
            '/v1/projects/proj/locations/global/workspaces/ws/invoke/v1/messages',
            $uri->getPath()
        );
    }

    // ── Organization routes ─────────────────────────────────────────

    public function testOrganizationRouteUsesOrganizationBaseUrl(): void
    {
        $client = $this->makeClient();

        $client->beta->organization->retrieve();
        $request = $this->getLastRequest();

        $this->assertSame(self::ORGANIZATION_BASE_URL.'/v1/organizations/me?beta=true', (string) $request->getUri());
        $this->assertSame('Bearer adc-token', $request->getHeaderLine('Authorization'));
    }

    public function testOrganizationRouteWithPathParameter(): void
    {
        $client = $this->makeClient();

        $client->organization->workspaces->retrieve('wrkspc_1');

        $this->assertSame(
            self::ORGANIZATION_BASE_URL.'/v1/organizations/workspaces/wrkspc_1',
            (string) $this->getLastRequest()->getUri()
        );
    }

    public function testBaseUrlSelectedPerRequest(): void
    {
        $client = $this->makeClient();

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->organization->retrieve();
        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $client->organization->retrieve();

        $this->assertSame(
            [
                self::ORGANIZATION_BASE_URL.'/v1/organizations/me',
                'https://claude.googleapis.com/v1/projects/proj/locations/us-east5/workspaces/ws/invoke/v1/messages',
                self::ORGANIZATION_BASE_URL.'/v1/organizations/me',
            ],
            $this->requestedUrls()
        );
    }

    public function testOnlyOrganizationPrefixUsesOrganizationBaseUrl(): void
    {
        $client = $this->makeClient();

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->request('get', '/v1/organizations/me');
        $client->request('get', 'v1/organizations_other/me');

        $this->assertSame(
            [
                self::ORGANIZATION_BASE_URL.'/v1/organizations/me',
                'https://claude.googleapis.com/v1/projects/proj/locations/us-east5/workspaces/ws/invoke/v1/organizations_other/me',
            ],
            $this->requestedUrls()
        );
    }

    public function testOrganizationRouteDoesNotRequireWorkspaceId(): void
    {
        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->beta->organization->retrieve();
        $request = $this->getLastRequest();

        $this->assertSame(self::ORGANIZATION_BASE_URL.'/v1/organizations/me?beta=true', (string) $request->getUri());
        $this->assertSame('Bearer tok', $request->getHeaderLine('Authorization'));
    }

    public function testWorkspaceRouteWithoutWorkspaceIdThrowsBeforeSending(): void
    {
        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/\$workspaceId.*ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID/');

        try {
            $client->messages->create(1024, [], 'claude-haiku-4-5');
        } finally {
            $this->assertCount(0, $this->transporter->getRequests());
        }
    }

    public function testOrganizationRouteNextPageKeepsOrganizationBaseUrl(): void
    {
        $this->transporter->addResponse($this->jsonResponse([
            'data' => [['id' => 'wrkspc_1']],
            'has_more' => true,
            'first_id' => 'wrkspc_1',
            'last_id' => 'wrkspc_1',
        ]));
        $this->transporter->addResponse($this->jsonResponse(['data' => [], 'has_more' => false]));

        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->beta->organization->workspaces->list()->getNextPage();
        $uri = $this->getLastRequest()->getUri();

        $this->assertCount(2, $this->transporter->getRequests());
        $this->assertSame('claude.googleapis.com', $uri->getHost());
        $this->assertSame(
            '/v1/projects/proj/locations/us-east5/claudeOrganization/invoke/v1/organizations/workspaces',
            $uri->getPath()
        );
        $this->assertStringContainsString('after_id=wrkspc_1', $uri->getQuery());
    }

    public function testExplicitBaseUrlTakesEveryRoute(): void
    {
        $client = new Client(
            project: 'proj',
            location: 'us-east5',
            workspaceId: 'ws',
            baseUrl: 'https://custom.example.com',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->beta->organization->retrieve();
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame(
            [
                'https://custom.example.com/v1/organizations/me?beta=true',
                'https://custom.example.com/v1/messages',
            ],
            $this->requestedUrls()
        );
    }

    public function testBaseUrlFromEnvVarTakesEveryRoute(): void
    {
        putenv('ANTHROPIC_GOOGLE_CLOUD_BASE_URL=https://env.example.com');

        $client = $this->makeClient();

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->beta->organization->retrieve();
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame(
            [
                'https://env.example.com/v1/organizations/me?beta=true',
                'https://env.example.com/v1/messages',
            ],
            $this->requestedUrls()
        );
    }

    public function testExplicitBaseUrlWithoutWorkspaceIdTakesEveryRoute(): void
    {
        $client = new Client(
            baseUrl: 'https://custom.example.com',
            tokenProvider: fn () => 'tok',
            requestOptions: ['transporter' => $this->transporter],
        );

        $this->transporter->addResponse($this->jsonResponse());
        $this->transporter->addResponse($this->jsonResponse());

        $client->beta->organization->retrieve();
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertSame(
            [
                'https://custom.example.com/v1/organizations/me?beta=true',
                'https://custom.example.com/v1/messages',
            ],
            $this->requestedUrls()
        );
        $this->assertSame('Bearer tok', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testProjectFromCredentialsForOrganizationRoute(): void
    {
        $creds = new class() implements FetchAuthTokenInterface, ProjectIdProviderInterface {
            public function fetchAuthToken(?callable $httpHandler = null): array
            {
                return ['access_token' => 'adc-token'];
            }

            public function getCacheKey(): string
            {
                return '';
            }

            public function getLastReceivedToken(): ?array
            {
                return null;
            }

            public function getProjectId(?callable $httpHandler = null): string
            {
                return 'creds-proj';
            }
        };

        $client = new Client(
            location: 'us-east5',
            googleCredentials: $creds,
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->beta->organization->retrieve();
        $request = $this->getLastRequest();

        $this->assertSame(
            'https://claude.googleapis.com/v1/projects/creds-proj/locations/us-east5/claudeOrganization/invoke/v1/organizations/me?beta=true',
            (string) $request->getUri()
        );
        $this->assertSame('Bearer adc-token', $request->getHeaderLine('Authorization'));
    }

    // ── Cross-origin redirect ───────────────────────────────────────

    public function testBearerNotSentOnCrossOriginRedirect(): void
    {
        $client = $this->makeClient();

        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(307)
                ->withHeader('Location', 'https://elsewhere.example/v1/messages')
        );
        $this->transporter->addResponse($this->jsonResponse());

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('Bearer adc-token', $requests[0]->getHeaderLine('Authorization'));
        $this->assertSame('elsewhere.example', $requests[1]->getUri()->getHost());
        $this->assertFalse($requests[1]->hasHeader('Authorization'));
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

    /** @param array<string,mixed> $body */
    private function jsonResponse(array $body = []): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;
    }

    private function stubCredentials(string $token): FetchAuthTokenInterface
    {
        $creds = $this->createMock(FetchAuthTokenInterface::class);
        $creds->method('fetchAuthToken')->willReturn(['access_token' => $token]);

        return $creds;
    }

    /** @return list<string> */
    private function requestedUrls(): array
    {
        return array_map(
            static fn (RequestInterface $request) => (string) $request->getUri(),
            array_values($this->transporter->getRequests())
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
