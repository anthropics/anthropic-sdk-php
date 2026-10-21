<?php

namespace Tests\Foundry;

use Anthropic\Core\Util;
use Anthropic\Foundry\Client;
use Anthropic\Foundry\ServiceClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
#[CoversNothing]
final class ClientTest extends TestCase
{
    private const BASE_URL = 'https://foundry.example.test/anthropic';

    private const ENV_KEYS = [
        'ANTHROPIC_FOUNDRY_API_KEY',
        'ANTHROPIC_FOUNDRY_BASE_URL',
        'ANTHROPIC_FOUNDRY_RESOURCE',
        'ANTHROPIC_API_KEY',
        'ANTHROPIC_AUTH_TOKEN',
    ];

    private const FIRST_PARTY_ENV = [
        'ANTHROPIC_API_KEY' => 'first-party-key',
        'ANTHROPIC_AUTH_TOKEN' => 'first-party-token',
        'ANTHROPIC_CUSTOM_HEADERS' => 'x-first-party: 1',
        'ANTHROPIC_BASE_URL' => 'https://first-party.example.test',
    ];

    private MockClient $transporter;

    /** @var array<string,string|null> */
    private array $clearedEnv = [];

    /** @var array<string, array{string|false, mixed}> */
    private array $savedEnv = [];

    protected function setUp(): void
    {
        $this->transporter = new MockClient;
        $this->transporter->setDefaultResponse(self::json('{}'));

        foreach (self::ENV_KEYS as $key) {
            $this->clearedEnv[$key] = Util::getenv($key);
            putenv($key);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->savedEnv as $key => [$value, $superglobal]) {
            putenv(false === $value ? $key : "{$key}={$value}");
            if (null === $superglobal) {
                unset($_ENV[$key]);
            } else {
                $_ENV[$key] = $superglobal;
            }
        }

        foreach ($this->clearedEnv as $key => $value) {
            if (null === $value) {
                putenv($key);
            } else {
                putenv("{$key}={$value}");
            }
        }
    }

    public function testApiKeyAuthSendsCorrectHeaders(): void
    {
        $this->makeResourceClient()->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame('my-foundry-key', $requests[0]->getHeaderLine('x-api-key'));
        $this->assertFalse($requests[0]->hasHeader('Authorization'));
    }

    public function testApiKeyFromEnvVar(): void
    {
        putenv('ANTHROPIC_FOUNDRY_API_KEY=env-key');

        $client = Client::fromEnvironment(
            resource: 'my-resource',
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame('env-key', $requests[0]->getHeaderLine('x-api-key'));
        $this->assertFalse($requests[0]->hasHeader('Authorization'));
    }

    public function testAnthropicApiKeyEnvDoesNotLeak(): void
    {
        putenv('ANTHROPIC_API_KEY=leaked-key');
        putenv('ANTHROPIC_AUTH_TOKEN=leaked-token');

        $this->makeResourceClient()->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame('my-foundry-key', $requests[0]->getHeaderLine('x-api-key'));
        $this->assertFalse($requests[0]->hasHeader('Authorization'));
    }

    public function testApiKeyNotSentOnCrossOriginRedirect(): void
    {
        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(307)
                ->withHeader('Location', 'https://elsewhere.example/v1/messages')
        );

        $this->makeResourceClient()->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('my-foundry-key', $requests[0]->getHeaderLine('x-api-key'));
        $this->assertSame('elsewhere.example', $requests[1]->getUri()->getHost());
        $this->assertFalse($requests[1]->hasHeader('x-api-key'));
        $this->assertFalse($requests[1]->hasHeader('Authorization'));
    }

    public function testSendsTheFirstPartyClientsVersion(): void
    {
        $this->makeResourceClient()->messages->create(1024, [], 'claude-haiku-4-5');

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame(\Anthropic\Client::ANTHROPIC_API_VERSION, $requests[0]->getHeaderLine('anthropic-version'));
    }

    /**
     * @param \Closure(Client): mixed $call
     * @param array<string, mixed>|null $body
     */
    #[DataProvider('userProfilesCalls')]
    public function testUserProfilesRequestsGoToTheFoundryBaseUrlWithTheApiKey(\Closure $call, string $method, string $path, ?array $body): void
    {
        $call($this->makeClient(apiKey: 'test-key'));
        $request = $this->getLastRequest();

        $this->assertSame($method, $request->getMethod());
        $this->assertSame(self::BASE_URL.$path, (string) $request->getUri());
        $this->assertSame('test-key', $request->getHeaderLine('x-api-key'));
        $this->assertFalse($request->hasHeader('Authorization'));
        $this->assertSame($body, json_decode((string) $request->getBody(), associative: true));
    }

    /**
     * These calls check routing only: where the request goes and which credential it carries. Which of these
     * endpoints a deployment serves is the platform's answer, not the client's.
     *
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

        yield 'actionURLs create' => [
            static fn (Client $client) => $client->userProfiles->actionURLs->create('uprof_1', action: ['type' => 'enroll_end_user']),
            'POST',
            '/v1/user_profiles/uprof_1/action_urls',
            ['action' => ['type' => 'enroll_end_user']],
        ];
    }

    public function testUserProfilesRequestsSendTheAuthTokenAsBearer(): void
    {
        $this->makeClient(authToken: 'test-token')->userProfiles->retrieve('uprof_1');
        $request = $this->getLastRequest();

        $this->assertSame('Bearer test-token', $request->getHeaderLine('Authorization'));
        $this->assertFalse($request->hasHeader('x-api-key'));
    }

    public function testUserProfilesRequestsSendTheCredentialTheClientHoldsNow(): void
    {
        $client = $this->makeClient(apiKey: 'test-key');
        $client->apiKey = 'rotated-key';

        $client->userProfiles->retrieve('uprof_1');

        $this->assertSame('rotated-key', $this->getLastRequest()->getHeaderLine('x-api-key'));
    }

    public function testUserProfilesNextPageGoesToTheFoundryBaseUrlWithTheApiKey(): void
    {
        $this->transporter->addResponse(self::json('{"data":[{"id":"uprof_1","type":"user_profile"}],"next_page":"page_2"}'));

        $this->makeClient(apiKey: 'test-key')->userProfiles->list(limit: 1)->getNextPage();
        $request = $this->getLastRequest();

        $this->assertSame(self::BASE_URL.'/v1/user_profiles?limit=1&page=page_2', (string) $request->getUri());
        $this->assertSame('test-key', $request->getHeaderLine('x-api-key'));
    }

    /**
     * @param array{apiKey?: string, authToken?: string} $credentials
     * @param array<string, string> $expected
     * @param list<string> $absent
     */
    #[DataProvider('foundryCredentials')]
    public function testUserProfilesRequestsIgnoreTheFirstPartyEnvironment(array $credentials, array $expected, array $absent): void
    {
        $this->setFirstPartyEnv();

        $this->makeClient(...$credentials)->userProfiles->retrieve('uprof_1');
        $request = $this->getLastRequest();

        $this->assertSame(self::BASE_URL.'/v1/user_profiles/uprof_1', (string) $request->getUri());
        foreach ($expected as $header => $value) {
            $this->assertSame($value, $request->getHeaderLine($header));
        }
        foreach ([...$absent, 'x-first-party'] as $header) {
            $this->assertFalse($request->hasHeader($header), "expected no {$header} header");
        }
    }

    /**
     * @return iterable<string, array{array{apiKey?: string, authToken?: string}, array<string, string>, list<string>}>
     */
    public static function foundryCredentials(): iterable
    {
        yield 'api key' => [['apiKey' => 'test-key'], ['x-api-key' => 'test-key'], ['Authorization']];

        yield 'auth token' => [['authToken' => 'test-token'], ['Authorization' => 'Bearer test-token'], ['x-api-key']];
    }

    public function testUserProfilesClientKeepsNoFirstPartyAuthToken(): void
    {
        $this->setFirstPartyEnv();

        $client = $this->makeClient(apiKey: 'test-key');
        $serviceClient = (new \ReflectionProperty($client->userProfiles, 'client'))->getValue($client->userProfiles);

        $this->assertInstanceOf(ServiceClient::class, $serviceClient);
        $this->assertSame('', $serviceClient->authToken);
        $this->assertStringNotContainsString(self::FIRST_PARTY_ENV['ANTHROPIC_AUTH_TOKEN'], print_r($client, true));
    }

    private function setFirstPartyEnv(): void
    {
        foreach (self::FIRST_PARTY_ENV as $key => $value) {
            $this->savedEnv[$key] = [getenv($key), $_ENV[$key] ?? null];
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }

    private function makeResourceClient(): Client
    {
        return Client::withCredentials(
            apiKey: 'my-foundry-key',
            resource: 'my-resource',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    private function makeClient(?string $apiKey = null, ?string $authToken = null): Client
    {
        return Client::withCredentials(
            apiKey: $apiKey,
            authToken: $authToken,
            baseUrl: self::BASE_URL,
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }

    private static function json(string $body): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body))
        ;
    }
}
