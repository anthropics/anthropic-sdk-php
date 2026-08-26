<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\RefreshTokenProvider;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class RefreshTokenProviderTest extends TestCase
{
    private MockClient $httpClient;

    private string $credentialsPath;

    protected function setUp(): void
    {
        $this->httpClient = new MockClient;
        $this->credentialsPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'anthropic_rt_test_'.uniqid().'.json';
    }

    protected function tearDown(): void
    {
        @unlink($this->credentialsPath);
    }

    public function testFreshStoredAccessTokenReturnedWithoutRefresh(): void
    {
        $this->writeCredentials(['access_token' => 'tok_disk', 'expires_at' => time() + 3600, 'refresh_token' => 'rt_disk']);

        $token = $this->makeProvider()->fetchToken();

        $this->assertSame('tok_disk', $token->token);
        $this->assertCount(0, $this->httpClient->getRequests());
    }

    public function testExpiredStoredTokenRefreshedWithDiskRefreshTokenAndPersisted(): void
    {
        $this->writeCredentials([
            'version' => '1.0',
            'scope' => 'user:inference',
            'access_token' => 'tok_old',
            'expires_at' => time() - 60,
            'refresh_token' => 'rt_disk',
        ]);
        $this->setMockResponse(200, ['access_token' => 'tok_new', 'expires_in' => 3600, 'refresh_token' => 'rt_rotated']);

        $token = $this->makeProvider(refreshToken: 'rt_stale')->fetchToken();

        $this->assertSame('tok_new', $token->token);
        $this->assertCount(1, $this->httpClient->getRequests());

        $request = $this->getLastRequest();
        $this->assertSame('/v1/oauth/token', $request->getUri()->getPath());
        $this->assertSame('oauth-2025-04-20', $request->getHeaderLine('anthropic-beta'));

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame(['grant_type' => 'refresh_token', 'refresh_token' => 'rt_disk', 'client_id' => 'client_test'], $body);

        $stored = $this->readCredentials();
        $this->assertSame('1.0', $stored['version']);
        $this->assertSame('user:inference', $stored['scope']);
        $this->assertSame('oauth_token', $stored['type']);
        $this->assertSame('tok_new', $stored['access_token']);
        $this->assertSame('rt_rotated', $stored['refresh_token']);
        $this->assertEqualsWithDelta(time() + 3600, $stored['expires_at'], 5);
        $this->assertSame(0600, fileperms($this->credentialsPath) & 0777);
    }

    public function testPicksUpAccessTokenRefreshedByAnotherProcess(): void
    {
        $this->writeCredentials(['access_token' => 'tok_a', 'expires_at' => time() + 3600, 'refresh_token' => 'rt_a']);
        $provider = $this->makeProvider();

        $this->assertSame('tok_a', $provider->fetchToken()->token);

        $this->writeCredentials(['access_token' => 'tok_b', 'expires_at' => time() + 3600, 'refresh_token' => 'rt_b']);

        $this->assertSame('tok_b', $provider->fetchToken()->token);
        $this->assertCount(0, $this->httpClient->getRequests());
    }

    public function testRefreshesWhenAskedAgainForTheTokenItLastIssued(): void
    {
        $this->writeCredentials(['access_token' => 'tok_a', 'expires_at' => time() + 3600, 'refresh_token' => 'rt_a']);
        $this->setMockResponse(200, ['access_token' => 'tok_new', 'expires_in' => 3600]);
        $provider = $this->makeProvider();

        $this->assertSame('tok_a', $provider->fetchToken()->token);
        $this->assertCount(0, $this->httpClient->getRequests());

        $this->assertSame('tok_new', $provider->fetchToken()->token);
        $this->assertCount(1, $this->httpClient->getRequests());
        $this->assertSame('rt_a', $this->readCredentials()['refresh_token']);
    }

    public function testFallsBackToConstructorRefreshTokenWhenFileIsMissing(): void
    {
        $this->setMockResponse(200, ['access_token' => 'tok_new', 'expires_in' => 3600]);

        $token = $this->makeProvider(refreshToken: 'rt_ctor')->fetchToken();

        $this->assertSame('tok_new', $token->token);

        /** @var array<string,mixed> $body */
        $body = json_decode((string) $this->getLastRequest()->getBody(), true);
        $this->assertSame('rt_ctor', $body['refresh_token']);
    }

    private function makeProvider(string $refreshToken = 'rt_ctor'): RefreshTokenProvider
    {
        return new RefreshTokenProvider(
            clientId: 'client_test',
            refreshToken: $refreshToken,
            credentialsFilePath: $this->credentialsPath,
            tokenEndpointBaseUrl: 'https://api.anthropic.com',
            httpClient: $this->httpClient,
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );
    }

    /**
     * @param array<string,mixed> $credentials
     */
    private function writeCredentials(array $credentials): void
    {
        file_put_contents($this->credentialsPath, json_encode($credentials, JSON_THROW_ON_ERROR));
        chmod($this->credentialsPath, 0600);
    }

    /**
     * @return array<mixed>
     */
    private function readCredentials(): array
    {
        $data = json_decode((string) file_get_contents($this->credentialsPath), true, flags: JSON_THROW_ON_ERROR);
        self::assertIsArray($data);

        return $data;
    }

    /**
     * @param array<string,mixed> $body
     */
    private function setMockResponse(int $status, array $body): void
    {
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body) ?: '{}'))
        ;

        $this->httpClient->setDefaultResponse($response);
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->httpClient->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
