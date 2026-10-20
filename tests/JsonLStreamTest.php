<?php

namespace Tests;

use Anthropic\Core\Contracts\BaseStream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\Utils;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class JsonLStreamTest extends TestCase
{
    private const EVENT = "{}\n";

    private const BODY = self::EVENT.self::EVENT.self::EVENT;

    public int $closes = 0;

    /**
     * @param \Closure(BaseStream<covariant mixed>): void $read
     */
    #[DataProvider('reads')]
    public function testFinishedStreamIsClosedOnce(\Closure $read): void
    {
        $stream = $this->stream();
        self::dirtyStack();
        $read($stream);
        unset($stream);

        $this->assertSame(1, $this->closes);
    }

    /**
     * @return iterable<string, array{\Closure(BaseStream<covariant mixed>): void}>
     */
    public static function reads(): iterable
    {
        yield 'read to the end' => [static function (BaseStream $stream): void {
            foreach ($stream as $_);
        }];

        yield 'closed before the first event' => [static function (BaseStream $stream): void {
            $stream->close();
        }];

        yield 'closed after the first event' => [static function (BaseStream $stream): void {
            foreach ($stream as $_) {
                break;
            }
            $stream->close();
        }];
    }

    public function testFailedStreamIsClosedWhileItsErrorIsHeld(): void
    {
        $stream = $this->stream(self::EVENT.str_replace('{}', '{', self::EVENT).self::EVENT);
        $error = null;

        try {
            foreach ($stream as $_);
        } catch (\Throwable $error) {
        }
        unset($stream);

        $this->assertNotNull($error);
        $this->assertSame(1, $this->closes);
    }

    public function testHeldStreamStaysOpen(): void
    {
        $stream = $this->stream();
        $seen = 0;
        foreach ($stream as $_) {
            $this->assertSame(0, $this->closes);
            ++$seen;
        }

        $this->assertSame(3, $seen);
    }

    /**
     * Leaves integers where PHP puts the frames of the next calls. PHP 8.3.30+, 8.4.17+ and 8.5.2+ read one of them
     * as a pointer when they destroy a suspended generator with a `finally` under an internal function and an exception.
     */
    private static function dirtyStack(): void
    {
        [$a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w, $x] = array_fill(0, 24, 2);
    }

    /**
     * @return BaseStream<covariant mixed>
     */
    private function stream(string $body = self::BODY): BaseStream
    {
        $transporter = new Client;
        $transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse()
                ->withHeader('Content-Type', 'application/jsonl')
                ->withBody(new class(Utils::streamFor($body), $this) implements StreamInterface {
                    use StreamDecoratorTrait;

                    public function __construct(private StreamInterface $stream, private JsonLStreamTest $test) {}

                    public function close(): void
                    {
                        ++$this->test->closes;
                        $this->stream->close();
                    }
                })
        );

        $client = new \Anthropic\Client(
            baseUrl: 'http://localhost',
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $transporter],
        );

        return $client->messages->batches->resultsStream('message_batch_id');
    }
}
