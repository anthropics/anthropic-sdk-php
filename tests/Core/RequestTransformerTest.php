<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Bedrock\BedrockMiddleware;
use Anthropic\Core\RequestTransformer;
use Anthropic\Middleware;
use Anthropic\Vertex\VertexMiddleware;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/** @internal */
final class RequestTransformerTest extends TestCase
{
    private const EMPTY_OBJECTS = '"metadata":{},'
        .'"messages":[{"role":"assistant","content":[{"type":"tool_use","id":"t","name":"n","input":{}}]}],'
        .'"tools":[{"name":"n","input_schema":{"type":"object","properties":{}}}]';

    public function testPathOnlyEditPreservesBodyStreamAndContentLength(): void
    {
        $factory = new HttpFactory();
        $body = $factory->createStream('{"model":"m","messages":[]}');
        $req = new Request('POST', 'https://h/v1/messages', ['Content-Length' => (string) $body->getSize()], $body);

        $out = (new RequestTransformer($req, $factory))
            ->setPath('/model/m/invoke')
            ->setHeader('X-A', '1')
            ->build();

        self::assertSame($body, $out->getBody());
        self::assertSame((string) $body->getSize(), $out->getHeaderLine('Content-Length'));
        self::assertSame('/model/m/invoke', $out->getUri()->getPath());
    }

    public function testNonJsonBodyIsFineWhenBodyUntouched(): void
    {
        $factory = new HttpFactory();
        $req = new Request('POST', 'https://h/v1/x?beta=true', [], $factory->createStream('not json'));

        $out = (new RequestTransformer($req, $factory))->dropQueryParam('beta')->build();

        self::assertSame('not json', (string) $out->getBody());
        self::assertSame('', $out->getUri()->getQuery());
    }

    public function testDropQueryParamPreservesEncodedArrayParams(): void
    {
        $factory = new HttpFactory();
        $req = new Request('GET', 'https://h/v1/x?ids%5B%5D=a&beta=true&ids%5B%5D=b%20c');

        $out = (new RequestTransformer($req, $factory))->dropQueryParam('beta')->build();

        self::assertSame('ids%5B%5D=a&ids%5B%5D=b%20c', $out->getUri()->getQuery());
    }

    public function testGetBodyParamDoesNotTriggerReencode(): void
    {
        $factory = new HttpFactory();
        $body = $factory->createStream('{"model":"m"}');
        $req = new Request('POST', 'https://h/v1/messages', [], $body);

        $r = new RequestTransformer($req, $factory);
        self::assertSame('m', $r->getBodyParam('model'));

        $out = $r->build();
        self::assertSame($body, $out->getBody());
        self::assertSame(0, $out->getBody()->tell());
        self::assertSame('{"model":"m"}', $out->getBody()->getContents());
    }

    public function testSetBodyParamDefaultIsNoOpWhenKeyPresent(): void
    {
        $factory = new HttpFactory();
        $body = $factory->createStream('{"anthropic_version":"v"}');
        $req = new Request('POST', 'https://h/v1/messages', [], $body);

        $out = (new RequestTransformer($req, $factory))
            ->setBodyParamDefault('anthropic_version', 'other')
            ->build();

        self::assertSame($body, $out->getBody());
    }

    public function testBodyMutationReencodesAndDropsContentLength(): void
    {
        $factory = new HttpFactory();
        $req = new Request('POST', 'https://h/v1/messages', ['Content-Length' => '21'], $factory->createStream('{"model":"m","k":"v"}'));

        $r = new RequestTransformer($req, $factory);
        self::assertSame('m', $r->takeBodyParam('model'));
        $built = $r->build();

        self::assertSame(['k' => 'v'], json_decode((string) $built->getBody(), true));
        self::assertFalse($built->hasHeader('Content-Length'));
    }

    public function testBodyMutationKeepsEmptyObjects(): void
    {
        $factory = new HttpFactory();
        $body = '{"model":"m",'.self::EMPTY_OBJECTS.'}';
        $req = new Request('POST', 'https://h/v1/messages', [], $factory->createStream($body));

        $r = new RequestTransformer($req, $factory);
        $r->takeBodyParam('model');

        self::assertSame('{'.self::EMPTY_OBJECTS.'}', (string) $r->build()->getBody());
    }

    /**
     * @return iterable<string, array{0: \Closure(HttpFactory, \Closure(RequestInterface): RequestInterface): Middleware, 1: string, 2: string, 3?: bool}>
     */
    public static function platformRewrites(): iterable
    {
        $bedrock = static fn (HttpFactory $f, \Closure $auth) => new BedrockMiddleware($f, $auth);
        $vertex = static fn (HttpFactory $f, \Closure $auth) => new VertexMiddleware($f, 'us-east5', static fn () => 'p', $auth);

        yield 'bedrock messages' => [
            $bedrock,
            '/v1/messages',
            '{"max_tokens":1,'.self::EMPTY_OBJECTS.',"anthropic_version":"bedrock-2023-05-31"}',
        ];

        yield 'bedrock count_tokens' => [
            $bedrock,
            '/v1/messages/count_tokens',
            '{"max_tokens":1024,'.self::EMPTY_OBJECTS.',"anthropic_version":"bedrock-2023-05-31"}',
            true,
        ];

        yield 'vertex messages' => [
            $vertex,
            '/v1/messages',
            '{"max_tokens":1,'.self::EMPTY_OBJECTS.',"anthropic_version":"vertex-2023-10-16"}',
        ];

        yield 'vertex count_tokens' => [
            $vertex,
            '/v1/messages/count_tokens',
            '{"model":"m","max_tokens":1,'.self::EMPTY_OBJECTS.',"anthropic_version":"vertex-2023-10-16"}',
        ];
    }

    /**
     * @param \Closure(HttpFactory, \Closure(RequestInterface): RequestInterface): Middleware $middleware
     */
    #[DataProvider('platformRewrites')]
    public function testPlatformRewriteKeepsEmptyObjects(\Closure $middleware, string $path, string $expected, bool $bedrockEnvelope = false): void
    {
        $factory = new HttpFactory();
        $body = '{"model":"m","max_tokens":1,'.self::EMPTY_OBJECTS.'}';
        $req = new Request('POST', "https://h{$path}", [], $factory->createStream($body));

        $sent = null;
        $middleware($factory, static fn (RequestInterface $r) => $r)->handle(
            $req,
            static function (RequestInterface $r) use (&$sent) {
                $sent = $r;

                return new Response(200, ['Content-Type' => 'application/json'], '{"input_tokens":1}');
            },
        );

        self::assertInstanceOf(RequestInterface::class, $sent);
        $body = (string) $sent->getBody();

        if ($bedrockEnvelope) {
            $outer = json_decode($body, associative: true, flags: JSON_THROW_ON_ERROR);
            self::assertIsArray($outer);
            self::assertIsArray($outer['input']);
            self::assertIsArray($outer['input']['invokeModel']);
            self::assertIsString($outer['input']['invokeModel']['body']);
            $body = base64_decode($outer['input']['invokeModel']['body'], strict: true);
        }

        self::assertSame($expected, $body);
    }
}
