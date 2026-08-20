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

        $client = Client::withAccessToken('static-token', location: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);
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
        $client = Client::withAccessToken('static-token', location: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);
        $client->messages->create(maxTokens: 1, messages: [], model: 'm@v', requestOptions: ['extraQueryParams' => $query]);

        $sent = $transporter->getLastRequest();
        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $sent);
        $expected = \Anthropic\Core\Util::joinUri(new \GuzzleHttp\Psr7\Uri(), path: '', query: $query)->getQuery();

        $this->assertSame('/v1/projects/p/locations/us-east5/publishers/anthropic/models/m@v:rawPredict', $sent->getUri()->getPath());
        $this->assertSame($expected, $sent->getUri()->getQuery());
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
