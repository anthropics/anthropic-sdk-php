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
    /**
     * @param \Generator<TEvent> $generator
     */
    private \Generator $generator;

    /**
     * @param \Generator<TRaw> $stream
     */
    public function __construct(
        protected string|Converter|ConverterSource $convert,
        protected RequestInterface $request,
        protected ResponseInterface $response,
        protected \Generator $stream,
    ) {
        $this->generator = $this->parsedGenerator();
    }

    /**
     * @return \Iterator<TEvent>
     */
    public function getIterator(): \Iterator
    {
        return $this->generator;
    }

    public function close(): void
    {
        try {
            $this->stream->throw(new IteratorExit);
        } catch (IteratorExit $_) {
            // IteratorExit shouldn't be noticed.
            return;
        }
    }

    /**
     * @return \Generator<TEvent> $stream
     */
    abstract private function parsedGenerator(): \Generator;
}
