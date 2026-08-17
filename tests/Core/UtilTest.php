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
                'http://localhost?dog[]=dog',
            ],
            [
                '',
                ['dog' => [true, false]],
                'http://localhost?dog[]=true&dog[]=false',
            ],
            [
                '',
                ['dog' => ['dog' => ['dog']]],
                'http://localhost?dog[dog][]=dog',
            ],
        ];

        foreach ($cases as [$path, $query, $output]) {
            $expected = $factory->createUri($output);
            $actual = Util::joinUri($base, path: $path, query: $query);
            $this->assertEquals($expected, $actual);
        }
    }

    #[Test]
    public function testJoinUriEncodesListQueryParamsWithEmptyBrackets(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();
        $base = $factory->createUri('http://localhost');

        $uri = Util::joinUri($base, path: '', query: ['types' => ['a', 'b']]);

        $this->assertSame('types%5B%5D=a&types%5B%5D=b', $uri->getQuery());
    }

    #[Test]
    public function testJoinUriQueryEncoding(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();
        $base = $factory->createUri('http://localhost');
        $cases = [
            // scalars keep their existing encoding
            [['limit' => 10, 'enabled' => true], 'limit=10&enabled=true'],
            [['q' => 'a+b c'], 'q=a%2Bb%20c'],
            [['k' => null, 'other' => 'x'], 'other=x'],
            // DateTimeInterface values use the SDK's date serialization
            [['created_at' => new \DateTimeImmutable('2026-01-02T03:04:05+00:00')], 'created_at=2026-01-02T03%3A04%3A05%2B00%3A00'],
            // associative arrays keep their keys
            [['created_at' => ['gt' => '1', 'lte' => '2']], 'created_at%5Bgt%5D=1&created_at%5Blte%5D=2'],
            [['created_at[gt]' => '2026-01-01'], 'created_at%5Bgt%5D=2026-01-01'],
            // generic map-like objects keep their associative expansion
            [['k' => (object) ['x' => 'y']], 'k%5Bx%5D=y'],
            // lists nested under associative keys use empty brackets
            [['f' => ['types' => ['a', 'b']]], 'f%5Btypes%5D%5B%5D=a&f%5Btypes%5D%5B%5D=b'],
            // non-list numeric keys are not treated as lists
            [['k' => [5 => 'a']], 'k%5B5%5D=a'],
            [['k' => [1 => 'a', 0 => 'b']], 'k%5B1%5D=a&k%5B0%5D=b'],
            // empty lists are omitted, as before
            [['k' => [], 'other' => 'x'], 'other=x'],
        ];

        foreach ($cases as [$query, $expected]) {
            $actual = Util::joinUri($base, path: '', query: $query);
            $this->assertSame($expected, $actual->getQuery());
        }
    }

    #[Test]
    public function testJoinUriMergesBaseAndPathQueries(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();

        $withBaseQuery = Util::joinUri(
            $factory->createUri('http://localhost?existing=1'),
            path: '',
            query: ['k' => 'v'],
        );
        $this->assertSame('existing=1&k=v', $withBaseQuery->getQuery());

        $withPathQuery = Util::joinUri(
            $factory->createUri('http://localhost'),
            path: 'dog?beta=true',
            query: ['types' => ['a']],
        );
        $this->assertSame('beta=true&types%5B%5D=a', $withPathQuery->getQuery());
    }

    #[Test]
    public function testMergeBodyStdClassBaseWithArrayExtra(): void
    {
        $body = (object) ['model' => 'claude-sonnet-4-5', 'max_tokens' => 1];
        $actual = Util::mergeBody($body, extraBody: ['max_tokens' => 2, 'extra' => 'yes']);

        $this->assertSame(
            ['model' => 'claude-sonnet-4-5', 'max_tokens' => 2, 'extra' => 'yes'],
            $actual,
        );
    }

    #[Test]
    public function testMergeBodyStdClassExtraIntoArrayBase(): void
    {
        $actual = Util::mergeBody(['a' => 1], extraBody: (object) ['b' => 2]);

        $this->assertSame(['a' => 1, 'b' => 2], $actual);
    }

    #[Test]
    public function testMergeBodyNullBaseTakesExtras(): void
    {
        $this->assertSame(['a' => 1], Util::mergeBody(null, extraBody: ['a' => 1]));
    }

    #[Test]
    public function testMergeBodyListBaseUntouched(): void
    {
        $body = [1, 2, 3];

        $this->assertSame($body, Util::mergeBody($body, extraBody: ['a' => 1]));
    }

    #[Test]
    public function testMergeBodyEmptyOrNullExtraIsNoOp(): void
    {
        $body = ['a' => 1];

        $this->assertSame($body, Util::mergeBody($body, extraBody: []));
        $this->assertSame($body, Util::mergeBody($body, extraBody: null));
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
