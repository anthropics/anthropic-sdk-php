<?php

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Implementation\IteratorExit;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @template TRaw mixed
 * @template TEvent
 *
 * @implements BaseStream<TEvent>
 */
trait SdkStream
{
    /** @var \Generator<TRaw> */
    protected \Generator $stream;

    /** @var \Generator<TEvent> */
    private \Generator $generator;

    private bool $closed = false;

    private bool $started = false;

    public function __construct(
        protected string|Converter|ConverterSource $convert,
        protected RequestInterface $request,
        protected ResponseInterface $response,
        protected mixed $parsedBody,
    ) {
        // @phpstan-ignore-next-line
        $this->stream = $parsedBody;
        $this->generator = (function (): \Generator {
            if ($this->closed) {
                return;
            }
            $this->started = true;

            yield from $this->parsedGenerator();
        })();
    }

    /** @return \Iterator<TEvent> */
    public function getIterator(): \Iterator
    {
        return $this->generator;
    }

    public function close(): void
    {
        if ($this->closed) {
            return;
        }
        $this->closed = true;

        try {
            // Throwing into an unstarted parser would first advance it to a
            // yield, which can perform a blocking body read merely to close.
            if ($this->started) {
                $this->generator->throw(new IteratorExit);
            }
        } catch (IteratorExit $_) {
            // IteratorExit shouldn't be noticed.
        } finally {
            $this->response->getBody()->close();
        }
    }

    /** @return \Generator<TEvent> $stream */
    abstract private function parsedGenerator(): \Generator;
}
