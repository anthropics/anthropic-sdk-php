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
    public function testJoinUriResolvesPathsAgainstBase(): void
    {
        $factory = Psr17FactoryDiscovery::findUriFactory();
        $base = $factory->createUri('http://localhost/prefix');
        $cases = [
            ['model/vendor.model-v1:0/invoke', 'http://localhost/prefix/model/vendor.model-v1:0/invoke'],
            ['dog?cat=meow#tail', 'http://localhost/prefix/dog?cat=meow'],
            ['/dog', 'http://localhost/dog'],
            ['https://example.com/absolute/path?dog=woof', 'https://example.com/absolute/path?dog=woof'],
            ['//example.com/absolute/path', 'http://example.com/absolute/path'],
        ];

        foreach ($cases as [$path, $output]) {
            $expected = $factory->createUri($output);
            $actual = Util::joinUri($base, path: $path);
            $this->assertEquals($expected, $actual);
        }
    }

    #[Test]
    public function testMergeBodyStdClassBaseWithArrayExtra(): void
    {
        $body = (object) ['model' => 'model-x', 'max_tokens' => 1];
        $actual = Util::mergeBody($body, extraBody: ['max_tokens' => 2, 'extra' => 'yes']);

        $this->assertSame(
            ['model' => 'model-x', 'max_tokens' => 2, 'extra' => 'yes'],
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
    public function testMergeBodyKeepsNumericStringKeys(): void
    {
        $actual = Util::mergeBody(['2024' => 'a', 'x' => 1], extraBody: ['2025' => 'b', 'x' => 2]);

        $this->assertSame(['2024' => 'a', 'x' => 2, '2025' => 'b'], $actual);
        $this->assertSame('{"2024":"a","x":2,"2025":"b"}', json_encode($actual));
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
