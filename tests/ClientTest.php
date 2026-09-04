<?php

namespace Tests;

use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Util;
use Anthropic\Messages\Model;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientTest extends TestCase
{
    public function testDefaultHeaders(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello, world', 'role' => 'user']],
            model: 'claude-opus-4-6',
        );

        $this->assertNotFalse($requested = $transporter->getRequests()[0] ?? false);

        foreach (['accept', 'content-type'] as $header) {
            $sent = $requested->getHeaderLine($header);
            $this->assertNotEmpty($sent);
        }
    }

    public function testCustomRequestPathResolvesAgainstBaseUrl(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost/prefix',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        $cases = [
            'model/vendor.model-v1:0/invoke' => ['http', 'localhost', '/prefix/model/vendor.model-v1:0/invoke'],
            '/model/vendor.model-v1:0/invoke' => ['http', 'localhost', '/prefix/model/vendor.model-v1:0/invoke'],
            'https://example.com/absolute/path?dog=woof' => ['https', 'example.com', '/absolute/path'],
        ];

        foreach ($cases as $path => [$scheme, $host, $expectedPath]) {
            $client->request('post', $path, body: ['hello' => 'world']);
            $this->assertInstanceOf(RequestInterface::class, $requested = $transporter->getLastRequest());
            $this->assertSame($scheme, $requested->getUri()->getScheme());
            $this->assertSame($host, $requested->getUri()->getHost());
            $this->assertSame($expectedPath, $requested->getUri()->getPath());
        }
    }

    public function testProtocolRelativeRedirectSwitchesHost(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost/prefix',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        $transporter->addResponse(Psr17FactoryDiscovery::findResponseFactory()->createResponse(302)->withHeader('Location', '//cdn.example.com/file?sig=abc'));

        $client->request('get', 'v1/thing');
        $this->assertInstanceOf(RequestInterface::class, $requested = $transporter->getLastRequest());
        $this->assertSame('http', $requested->getUri()->getScheme());
        $this->assertSame('cdn.example.com', $requested->getUri()->getHost());
        $this->assertSame('/file', $requested->getUri()->getPath());
        $this->assertStringContainsString('sig=abc', $requested->getUri()->getQuery());
    }

    public function testNonJsonErrorBody(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(413)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('length limit exceeded'))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        try {
            $client->messages->create(
                maxTokens: 1024,
                messages: [['content' => 'Hello, world', 'role' => 'user']],
                model: Model::CLAUDE_OPUS_5,
            );
            $this->fail('Expected an API status exception');
        } catch (APIStatusException $e) {
            $this->assertSame(413, $e->status);
            $this->assertSame('length limit exceeded', $e->body);
            $this->assertStringContainsString('"body": "length limit exceeded"', $e->getMessage());
        }
    }

    public function testEmptyErrorBody(): void
    {
        $transporter = new Client;
        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(413)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(''))
        ;

        $transporter->setDefaultResponse($mockRsp);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        try {
            $client->messages->create(
                maxTokens: 1024,
                messages: [['content' => 'Hello, world', 'role' => 'user']],
                model: Model::CLAUDE_OPUS_5,
            );
            $this->fail('Expected an API status exception');
        } catch (APIStatusException $e) {
            $this->assertSame(413, $e->status);
            $this->assertNull($e->body);
            $this->assertStringContainsString('"body": null', $e->getMessage());
        }
    }

    public function testStreamedErrorStatusRaisesStatusException(): void
    {
        $mock = new MockHandler([
            new Response(400, ['Content-Type' => 'application/json'], '{"error":{"message":"invalid"}}'),
        ]);
        $transporter = new \GuzzleHttp\Client(['handler' => HandlerStack::create($mock)]);

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        try {
            foreach ($client->messages->createStream(
                maxTokens: 1024,
                messages: [['content' => 'Hello, world', 'role' => 'user']],
                model: Model::CLAUDE_OPUS_5,
            ) as $_);

            $this->fail('expected an APIStatusException');
        } catch (APIStatusException $e) {
            $this->assertSame(400, $e->status);
        }
    }
}
