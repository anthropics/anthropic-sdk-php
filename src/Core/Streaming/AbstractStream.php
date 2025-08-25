<?php

namespace Anthropic\Core\Streaming;

use Anthropic\Core\Contracts\BaseStream;

/**
 * @internal
 *
 * @template TRaw mixed
 * @template TEvent
 *
 * @implements BaseStream<TEvent>
 */
abstract class AbstractStream implements BaseStream
{
    /**
     * @param \Generator<TEvent> $generator
     */
    private \Generator $generator;

    /**
     * @param \Generator<TRaw> $stream
     */
    public function __construct(
        protected string $decodeTarget,
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

    abstract protected function parsedGenerator(): \Generator;
}
