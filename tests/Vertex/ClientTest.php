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
        yield 'global region' => ['global', 'https://aiplatform.googleapis.com'];

        yield 'us region' => ['us', 'https://aiplatform.us.rep.googleapis.com'];

        yield 'us-central1 region' => ['us-central1', 'https://us-central1-aiplatform.googleapis.com'];

        yield 'europe-west1 region' => ['europe-west1', 'https://europe-west1-aiplatform.googleapis.com'];

        yield 'asia-southeast1 region' => ['asia-southeast1', 'https://asia-southeast1-aiplatform.googleapis.com'];
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
