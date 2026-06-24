<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Core\RequestTransformer;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

/** @internal */
final class RequestTransformerTest extends TestCase
{
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
}
