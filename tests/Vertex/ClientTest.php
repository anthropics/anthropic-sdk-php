<?php

namespace Tests\Vertex;

use Anthropic\Vertex\Client;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientTest extends TestCase
{
    private const FACTORIES = ['fromEnvironment', 'withCredentials', 'withAccessToken'];

    /**
     * @dataProvider locationBaseUrlProvider
     */
    public function testBaseUrlForLocation(string $location, string $expectedHost): void
    {
        $client = $this->createClientWithLocation($location);

        $reflection = new \ReflectionMethod($client, 'getBaseUrl');
        $baseUrl = $reflection->invoke($client);

        $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $baseUrl);
        $this->assertSame($expectedHost, (string) $baseUrl);
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function locationBaseUrlProvider(): iterable
    {
        yield 'global region' => ['global', 'https://aiplatform.googleapis.com/v1'];

        yield 'us region' => ['us', 'https://aiplatform.us.rep.googleapis.com/v1'];

        yield 'us-central1 region' => ['us-central1', 'https://us-central1-aiplatform.googleapis.com/v1'];

        yield 'eu region' => ['eu', 'https://aiplatform.eu.rep.googleapis.com/v1'];

        yield 'europe-west1 region' => ['europe-west1', 'https://europe-west1-aiplatform.googleapis.com/v1'];

        yield 'asia-southeast1 region' => ['asia-southeast1', 'https://asia-southeast1-aiplatform.googleapis.com/v1'];
    }

    public function testWithAccessTokenSetsBearerAuthorization(): void
    {
        $transporter = new \Http\Mock\Client();
        $transporter->setDefaultResponse(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}'));

        $client = Client::withAccessToken('static-token', region: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);
        $client->messages->create(maxTokens: 1, messages: [], model: 'm@v');

        $sent = $transporter->getLastRequest();
        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $sent);
        $this->assertSame('Bearer static-token', $sent->getHeaderLine('Authorization'));
    }

    public function testExtraQueryParamsKeepGeneratedEncoding(): void
    {
        $transporter = new \Http\Mock\Client();
        $transporter->setDefaultResponse(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}'));

        $query = ['ids' => ['a', 'b c']];
        $client = Client::withAccessToken('static-token', region: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);
        $client->messages->create(maxTokens: 1, messages: [], model: 'm@v', requestOptions: ['extraQueryParams' => $query]);

        $sent = $transporter->getLastRequest();
        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $sent);
        $expected = \Anthropic\Core\Util::joinUri(new \GuzzleHttp\Psr7\Uri(), path: '', query: $query)->getQuery();

        $this->assertSame('/v1/projects/p/locations/us-east5/publishers/anthropic/models/m@v:rawPredict', $sent->getUri()->getPath());
        $this->assertSame($expected, $sent->getUri()->getQuery());
    }

    /**
     * @param \Closure(): Client $factory
     *
     * @dataProvider regionArgumentProvider
     */
    public function testFactoriesAcceptRegionOrDeprecatedLocation(\Closure $factory): void
    {
        $client = $factory();

        $baseUrl = (new \ReflectionMethod($client, 'getBaseUrl'))->invoke($client);
        $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $baseUrl);
        $this->assertSame('https://europe-west1-aiplatform.googleapis.com/v1', (string) $baseUrl);
    }

    /**
     * @return iterable<string, array{\Closure(): Client}>
     */
    public static function regionArgumentProvider(): iterable
    {
        foreach (self::FACTORIES as $factory) {
            yield "{$factory} with region" => [static fn () => self::create($factory, region: 'europe-west1')];

            yield "{$factory} with location" => [static fn () => self::create($factory, location: 'europe-west1')];

            yield "{$factory} with equal region and location" => [static fn () => self::create($factory, region: 'europe-west1', location: 'europe-west1')];
        }

        yield 'fromEnvironment positional' => [static fn () => Client::fromEnvironment('europe-west1', 'p')];

        yield 'withCredentials positional' => [static fn () => Client::withCredentials(self::fakeCreds(), 'europe-west1', 'p')];

        yield 'withAccessToken positional' => [static fn () => Client::withAccessToken('static-token', 'europe-west1', 'p')];
    }

    /**
     * @param \Closure(): Client $factory
     *
     * @dataProvider invalidRegionArgumentProvider
     */
    public function testFactoriesRejectInvalidRegionArguments(\Closure $factory, string $message): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        $factory();
    }

    /**
     * @return iterable<string, array{\Closure(): Client, string}>
     */
    public static function invalidRegionArgumentProvider(): iterable
    {
        foreach (self::FACTORIES as $factory) {
            yield "{$factory} with conflicting region and location" => [
                static fn () => self::create($factory, region: 'europe-west1', location: 'us-east5'),
                'The `region` and `location` arguments conflict',
            ];

            yield "{$factory} without region" => [static fn () => self::create($factory), 'The `region` argument is required.'];
        }
    }

    /**
     * @param value-of<self::FACTORIES> $factory
     * @param non-empty-string|null $region
     * @param non-empty-string|null $location
     */
    private static function create(string $factory, ?string $region = null, ?string $location = null): Client
    {
        return match ($factory) {
            'fromEnvironment' => Client::fromEnvironment(region: $region, projectId: 'p', location: $location),
            'withCredentials' => Client::withCredentials(self::fakeCreds(), region: $region, projectId: 'p', location: $location),
            'withAccessToken' => Client::withAccessToken('static-token', region: $region, projectId: 'p', location: $location),
        };
    }

    private static function fakeCreds(): \Google\Auth\FetchAuthTokenInterface
    {
        return new class() implements \Google\Auth\FetchAuthTokenInterface {
            public function fetchAuthToken(?callable $httpHandler = null): array
            {
                return ['access_token' => 'static-token'];
            }

            public function getCacheKey(): ?string
            {
                return null;
            }

            public function getLastReceivedToken(): ?array
            {
                return null;
            }
        };
    }

    private function createClientWithLocation(string $location): Client
    {
        $reflection = new \ReflectionClass(Client::class);
        $constructor = $reflection->getConstructor();
        assert(null !== $constructor);

        $client = $reflection->newInstanceWithoutConstructor();

        $credentialsProvider = function () {
            throw new \RuntimeException('Should not be called in tests');
        };

        $constructor->invoke($client, $credentialsProvider, $location, 'test-project');

        return $client;
    }
}
