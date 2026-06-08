<?php

namespace Tests\Core;

use Anthropic\Aws\Client as AwsClient;
use Anthropic\Bedrock\Client as BedrockClient;
use Anthropic\Bedrock\MantleClient;
use Anthropic\Foundry\Client as FoundryClient;
use Anthropic\Middleware;
use Anthropic\Vertex\Client as VertexClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Confirms the middleware surface — constructor/factory `middleware:` option,
 * the `middleware()` reader, and the `withMiddleware()` deriver (with service
 * rewiring) — works identically on the Bedrock/Vertex/Foundry/Aws clients.
 *
 * @internal
 */
#[CoversNothing]
final class MiddlewareClientParityTest extends TestCase
{
    #[Test]
    public function testBedrock(): void
    {
        $transporter = $this->transporter();
        $ran = false;
        $base = $this->recorder($ran);

        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $transporter],
            middleware: [$base],
        );

        $client->request('GET', '/');

        $this->assertTrue($ran);
        $this->assertSame([$base], $client->middleware());
        $this->assertCount(1, $transporter->getRequests());

        $derived = $client->withMiddleware($this->passthrough());
        $this->assertCount(2, $derived->middleware());
        $this->assertSame([$base], $client->middleware());
        $this->assertNotSame($client->messages, $derived->messages);
    }

    #[Test]
    public function testFoundry(): void
    {
        $transporter = $this->transporter();
        $ran = false;
        $base = $this->recorder($ran);

        $client = FoundryClient::withCredentials(
            apiKey: 'test-key',
            baseUrl: 'http://localhost',
            requestOptions: ['transporter' => $transporter],
            middleware: [$base],
        );

        $client->request('GET', '/');

        $this->assertTrue($ran);
        $this->assertSame([$base], $client->middleware());
        $this->assertCount(1, $transporter->getRequests());

        $derived = $client->withMiddleware($this->passthrough());
        $this->assertCount(2, $derived->middleware());
        $this->assertNotSame($client->messages, $derived->messages);
    }

    #[Test]
    public function testAws(): void
    {
        $transporter = $this->transporter();
        $ran = false;
        $base = $this->recorder($ran);

        $client = new AwsClient(
            apiKey: 'test-key',
            awsRegion: 'us-east-1',
            workspaceId: 'default',
            requestOptions: ['transporter' => $transporter],
            middleware: [$base],
        );

        $client->request('GET', '/');

        $this->assertTrue($ran);
        $this->assertSame([$base], $client->middleware());
        $this->assertCount(1, $transporter->getRequests());

        $derived = $client->withMiddleware($this->passthrough());
        $this->assertCount(2, $derived->middleware());
        $this->assertNotSame($client->messages, $derived->messages);
    }

    #[Test]
    public function testBedrockMantle(): void
    {
        $transporter = $this->transporter();
        $ran = false;
        $base = $this->recorder($ran);

        $client = new MantleClient(
            apiKey: 'test-key',
            awsRegion: 'us-east-1',
            requestOptions: ['transporter' => $transporter],
            middleware: [$base],
        );

        $client->request('GET', '/');

        $this->assertTrue($ran);
        $this->assertSame([$base], $client->middleware());
        $this->assertCount(1, $transporter->getRequests());

        $derived = $client->withMiddleware($this->passthrough());
        $this->assertCount(2, $derived->middleware());
        $this->assertSame([$base], $client->middleware());
        $this->assertNotSame($client->messages, $derived->messages);
    }

    #[Test]
    public function testVertex(): void
    {
        // Vertex's transformRequest needs Google credentials, so use a
        // short-circuit middleware: it proves requestOptions (and middleware)
        // now thread through Vertex without ever reaching auth/transport.
        $ran = false;
        $canned = $this->response();
        $base = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran, $canned): ResponseInterface {
                $ran = true;

                return $canned;
            },
        );

        $client = $this->makeVertex(['middleware' => [$base]]);

        $client->request('GET', '/');

        $this->assertTrue($ran);
        $this->assertSame([$base], $client->middleware());

        $derived = $client->withMiddleware($this->passthrough());
        $this->assertCount(2, $derived->middleware());
        $this->assertNotSame($client->messages, $derived->messages);
    }

    /**
     * @param array<string,mixed> $requestOptions
     */
    private function makeVertex(array $requestOptions): VertexClient
    {
        // Mirror the existing Vertex test: construct via reflection with a
        // credentials provider that must never be invoked.
        $reflection = new \ReflectionClass(VertexClient::class);
        $constructor = $reflection->getConstructor();
        assert(null !== $constructor);

        $client = $reflection->newInstanceWithoutConstructor();
        $credentialsProvider = static function (): void {
            throw new \RuntimeException('credentials should not be resolved in this test');
        };

        $constructor->invoke($client, $credentialsProvider, 'us-central1', 'test-project', $requestOptions);

        return $client;
    }

    /**
     * A pass-through middleware that flips $ran when it executes.
     *
     * @return callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
     */
    private function recorder(bool &$ran): callable
    {
        return $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran): ResponseInterface {
                $ran = true;

                return $next($req);
            },
        );
    }

    /**
     * @return callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
     */
    private function passthrough(): callable
    {
        return $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next($req),
        );
    }

    /**
     * @param callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface $fn
     *
     * @return callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
     */
    private function mw(callable $fn): callable
    {
        return $fn;
    }

    private function transporter(): MockClient
    {
        $transporter = new MockClient;
        $transporter->setDefaultResponse($this->response());

        return $transporter;
    }

    private function response(): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{}'))
        ;
    }
}
