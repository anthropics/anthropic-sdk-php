<?php

namespace Anthropic\Core\Streaming;

/**
 * @internal
 *
 * @template TRaw mixed
 * @template TEvent
 *
 * @implements \IteratorAggregate<int,  TEvent>
 */
abstract class BaseStream implements \IteratorAggregate
{
    /**
     * @param \Generator< TEvent> $generator
     */
    private \Generator $generator;

    /**
     * @param \Generator<TRaw> $rawStream
     */
    public function __construct(
        protected string $decodeTarget,
        \Generator $rawStream,
    ) {
        $this->generator = $this->parsedGenerator($rawStream);
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
            $this->generator->throw(new IteratorExit);
        } catch (IteratorExit $_) {
            // IteratorExit shouldn't be noticed.
            return;
        }
    }

    /**
     * @param \Generator<TRaw> $rawStream
     */
    abstract public function parsedGenerator(\Generator $rawStream): \Generator;
}
