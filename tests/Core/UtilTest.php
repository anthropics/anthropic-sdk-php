<?php

namespace Tests\Core;

use Anthropic\Core\Util;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class UtilTest extends TestCase
{
    #[Test]
    public function testMapRecursive(): void
    {
        $cases = [
            [
                [],
                [],
                static fn ($v) => $v,
            ],
            [
                ['a' => null, 'b' => [null, null], 'c' => ['d' => null, 'e' => 0], 'f' => ['g' => null]],
                ['b' => [null, null], 'c' => ['e' => 0], 'f' => []],
                static fn ($vs) => is_array($vs) && !array_is_list($vs) ? array_filter($vs, callback: static fn ($v) => !is_null($v)) : $vs,
            ],
            [
                ['a' => null, 'b' => 2, 'c' => true, 'd' => [1, 2]],
                ['a' => null, 'b' => '2', 'c' => true, 'd' => ['1', '2']],
                static fn ($v) => is_bool($v) || is_numeric($v) ? Util::strVal($v) : $v,
            ],
        ];

        foreach ($cases as [$input, $expected, $xform]) {
            $actual = Util::mapRecursive($xform, value: $input);
            $this->assertEquals($expected, $actual);
        }
    }

    #[Test]
    public function testJoinUri(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();
        $base = $factory->createUri('http://localhost');
        $cases = [
            [
                '',
                [],
                'http://localhost',
            ],
            [
                'dog',
                [],
                'http://localhost/dog',
            ],
            [
                '',
                ['dog' => 'dog'],
                'http://localhost?dog=dog',
            ],
            [
                '',
                ['dog' => ['dog']],
                'http://localhost?dog[0]=dog',
            ],
            [
                '',
                ['dog' => [true, false]],
                'http://localhost?dog[0]=true&dog[1]=false',
            ],
            [
                '',
                ['dog' => ['dog' => ['dog']]],
                'http://localhost?dog[dog][0]=dog',
            ],
        ];

        foreach ($cases as [$path, $query, $output]) {
            $expected = $factory->createUri($output);
            $actual = Util::joinUri($base, path: $path, query: $query);
            $this->assertEquals($expected, $actual);
        }
    }

    #[Test]
    public function testDecodeContentFallsBackToRequestAccept(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'http://localhost')
            ->withHeader('Accept', 'application/x-jsonl')
        ;
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream("{\"id\":1}\n{\"id\":2}\n"))
        ;

        /** @var \Generator $decoded */
        $decoded = Util::decodeContent($response, request: $request);
        $this->assertSame(
            [['id' => 1], ['id' => 2]],
            iterator_to_array($decoded),
        );
    }

    #[Test]
    public function testGetenvFromGlobalEnv(): void
    {
        $_ENV[__FUNCTION__] = __FUNCTION__;

        try {
            $this->assertSame(__FUNCTION__, Util::getenv(__FUNCTION__));
        } finally {
            unset($_ENV[__FUNCTION__]);
        }
    }

    #[Test]
    public function testGetenvAfterPutEnv(): void
    {
        putenv(__FUNCTION__.'='.__FUNCTION__);

        try {
            $this->assertSame(__FUNCTION__, Util::getenv(__FUNCTION__));
        } finally {
            putenv(__FUNCTION__);
        }
    }

    #[Test]
    public function testGetenvThrowsWithMessageForInvalidEnv(): void
    {
        $_ENV[__FUNCTION__] = 123;

        $this->expectException(\InvalidArgumentException::class);

        try {
            Util::getenv(__FUNCTION__);
        } finally {
            unset($_ENV[__FUNCTION__]);
        }
    }
}
