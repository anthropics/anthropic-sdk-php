<?php

namespace Tests\Vertex;

use Anthropic\Core\Util;
use Anthropic\Vertex\Client;
use Anthropic\Vertex\VertexMiddleware;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
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

    public function testAnthropicCredentialEnvDoesNotLeak(): void
    {
        $names = ['ANTHROPIC_API_KEY', 'ANTHROPIC_AUTH_TOKEN'];
        $original = array_map(Util::getenv(...), array_combine($names, $names));
        putenv('ANTHROPIC_API_KEY=leaked-key');
        putenv('ANTHROPIC_AUTH_TOKEN=leaked-token');

        try {
            $client = Client::withAccessToken('static-token', region: 'us-east5', projectId: 'p');
        } finally {
            foreach ($original as $name => $value) {
                putenv(is_null($value) ? $name : "{$name}={$value}");
            }
        }

        $this->assertSame('', $client->apiKey);
        $this->assertSame('', $client->authToken);
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
     * @dataProvider modelsPathProvider
     */
    public function testProjectIdAndRegionAreEachSentAsOnePathSegment(string $projectId, string $region, ?string $baseUrl, string $expected): void
    {
        $transporter = new \Http\Mock\Client;
        $transporter->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{}'));
        $transporter->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{}'));

        $client = $this->createClientWithLocation($region, $projectId, $baseUrl, $transporter);
        $client->messages->create(maxTokens: 1, messages: [], model: 'm@v');
        $client->messages->countTokens(messages: [], model: 'm@v');

        $this->assertSame(
            [
                "{$expected}/publishers/anthropic/models/m@v:rawPredict",
                "{$expected}/publishers/anthropic/models/count-tokens:rawPredict",
            ],
            array_map(static fn ($request) => (string) $request->getUri(), array_values($transporter->getRequests())),
        );
    }

    /**
     * @return iterable<string, array{string, string, string|null, string}>
     */
    public static function modelsPathProvider(): iterable
    {
        // Real values are sent exactly as given.
        yield 'project id and a region' => ['my-project', 'us-east5', null, 'https://us-east5-aiplatform.googleapis.com/v1/projects/my-project/locations/us-east5'];

        yield 'domain-scoped project id and global' => ['example.com:my-project', 'global', null, 'https://aiplatform.googleapis.com/v1/projects/example.com:my-project/locations/global'];

        yield 'slash in project id' => ['a/b', 'us-east5', null, 'https://us-east5-aiplatform.googleapis.com/v1/projects/a%2Fb/locations/us-east5'];

        yield 'slash in region' => ['p', 'a/b', 'https://example.com/v1', 'https://example.com/v1/projects/p/locations/a%2Fb'];

        yield 'semicolon in project id' => ['a;b', 'us-east5', null, 'https://us-east5-aiplatform.googleapis.com/v1/projects/a;b/locations/us-east5'];

        yield 'semicolon in region' => ['p', 'a;b', 'https://example.com/v1', 'https://example.com/v1/projects/p/locations/a;b'];
    }

    /**
     * @dataProvider refusedPathValueProvider
     */
    public function testProjectIdAndRegionRefuseDotSegmentsAndEmptyValues(string $projectId, string $region, string $message): void
    {
        $transporter = new \Http\Mock\Client;
        $client = $this->createClientWithLocation($region, $projectId, 'https://example.com/v1', $transporter);

        $calls = [
            static fn () => $client->messages->create(maxTokens: 1, messages: [], model: 'm@v'),
            static fn () => $client->messages->countTokens(messages: [], model: 'm@v'),
        ];
        foreach ($calls as $call) {
            try {
                $call();
                $this->fail('expected the value to be refused');
            } catch (\InvalidArgumentException $e) {
                $this->assertStringContainsString($message, $e->getMessage());
            }
        }

        $this->assertSame([], $transporter->getRequests());
    }

    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function refusedPathValueProvider(): iterable
    {
        $refused = [
            '.' => 'dot segment "."',
            '..' => 'dot segment ".."',
            '' => 'empty path parameter',
            '.;x' => 'dot segment ".;x"',
            '..;x' => 'dot segment "..;x"',
            ';x' => 'empty path parameter',
        ];
        foreach ($refused as $value => $message) {
            yield "project id \"{$value}\"" => [$value, 'us-east5', $message];

            yield "region \"{$value}\"" => ['p', $value, $message];
        }
    }

    /**
     * @dataProvider refusedModelProvider
     */
    public function testModelThatIsEmptyOrADotSegmentBeforeItsSemicolonThrowsBeforeAnyRequestIsSent(string $model, string $message): void
    {
        $transporter = new \Http\Mock\Client;
        $client = Client::withAccessToken('static-token', region: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);

        $calls = [
            static fn () => $client->messages->create(maxTokens: 1, messages: [], model: $model),
            static fn () => $client->messages->createStream(maxTokens: 1, messages: [], model: $model),
        ];
        foreach ($calls as $call) {
            try {
                $call();
                $this->fail("expected the model \"{$model}\" to be refused");
            } catch (\InvalidArgumentException $e) {
                $this->assertStringContainsString($message, $e->getMessage());
            }
        }

        $this->assertSame([], $transporter->getRequests());
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function refusedModelProvider(): iterable
    {
        foreach (['', ';', ';x', ';a=b', ';..'] as $model) {
            yield "\"{$model}\"" => [$model, 'non-empty string `model`'];
        }

        foreach (['.;x', '..;x', '..;', '.;a=b'] as $model) {
            yield "\"{$model}\"" => [$model, "/publishers/anthropic/models/{$model}\" has the dot segment \"{$model}\""];
        }
    }

    public function testRefusedModelThrowsWithoutResolvingTheProjectId(): void
    {
        $factory = new HttpFactory;
        $middleware = new VertexMiddleware(
            $factory,
            'us-east5',
            static fn () => throw new \LogicException('the project ID was resolved'),
            static fn ($request) => $request,
        );
        $request = $factory->createRequest('POST', 'https://example.com/v1/messages')->withBody($factory->createStream('{"model":"..;x"}'));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('dot segment "..;x"');

        $middleware->handle($request, static fn () => throw new \LogicException('the request was sent'));
    }

    /**
     * @dataProvider sentModelProvider
     */
    public function testAnyOtherModelIsSentAsOnePathSegment(string $model, string $segment): void
    {
        $transporter = new \Http\Mock\Client;
        $transporter->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{}'));
        $transporter->addResponse(new Response(200, ['Content-Type' => 'text/event-stream'], ''));

        $client = Client::withAccessToken('static-token', region: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);
        $client->messages->create(maxTokens: 1, messages: [], model: $model);
        $client->messages->createStream(maxTokens: 1, messages: [], model: $model);

        $this->assertSame(
            [
                "/v1/projects/p/locations/us-east5/publishers/anthropic/models/{$segment}:rawPredict",
                "/v1/projects/p/locations/us-east5/publishers/anthropic/models/{$segment}:streamRawPredict",
            ],
            array_map(static fn ($request) => $request->getUri()->getPath(), array_values($transporter->getRequests())),
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function sentModelProvider(): iterable
    {
        yield 'a;b' => ['a;b', 'a%3Bb'];

        yield '...;x' => ['...;x', '...%3Bx'];

        yield '..x;y' => ['..x;y', '..x%3By'];

        yield 'x;..' => ['x;..', 'x%3B..'];

        yield 'a;b/c' => ['a;b/c', 'a%3Bb%2Fc'];

        // The method name shares the model's segment, so neither of these is a dot segment.
        yield '.' => ['.', '.'];

        yield '..' => ['..', '..'];
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

    /**
     * Calls the private constructor, which takes values the factories' types rule out, such as "".
     * Credentials are only available when a transporter is given.
     */
    private function createClientWithLocation(string $location, string $projectId = 'test-project', ?string $baseUrl = null, ?\Http\Mock\Client $transporter = null): Client
    {
        $reflection = new \ReflectionClass(Client::class);
        $constructor = $reflection->getConstructor();
        assert(null !== $constructor);

        $client = $reflection->newInstanceWithoutConstructor();

        $credentialsProvider = function () use ($transporter) {
            return null !== $transporter ? self::fakeCreds() : throw new \RuntimeException('Should not be called in tests');
        };
        $requestOptions = null !== $transporter ? ['transporter' => $transporter] : null;

        $constructor->invoke($client, $credentialsProvider, $location, $projectId, $baseUrl, $requestOptions);

        return $client;
    }
}
