<?php

declare(strict_types=1);

namespace Anthropic\Core\Implementation;

use Anthropic\Core\Contracts\BaseStream;

/**
 * @internal
 *
 * What a traced API call returns in place of `$stream`. Iterating it reads `$events`, a generator over that stream's events that ends the call span.
 *
 * @template TInner
 *
 * @implements BaseStream<TInner>
 */
final class TracedStream implements BaseStream
{
    /** @var \Generator<TInner> */
    private \Generator $iterator;

    /** @var \ArrayObject<int, \Generator<TInner>> `$events`, until the first read or `close()` takes it out */
    private \ArrayObject $unread;

    /**
     * @param BaseStream<TInner> $stream
     * @param \Generator<TInner> $events
     */
    public function __construct(private BaseStream $stream, \Generator $events)
    {
        $this->unread = $unread = new \ArrayObject([$events]);
        $this->iterator = (static function () use ($unread): \Generator {
            /** @var \Generator<TInner> $events */
            foreach ($unread->exchangeArray([]) as $events) {
                yield from $events;
            }
        })();
    }

    public function getIterator(): \Iterator
    {
        return $this->iterator;
    }

    public function close(): void
    {
        [$iterator, $this->iterator] = [$this->iterator, (static fn (): \Generator => yield from [])()];

        try {
            // Taking out events that nothing has read frees them, which ends the span with no status, as for a dropped stream.
            if (0 === count($this->unread->exchangeArray([]))) {
                $iterator->throw(new IteratorExit);
            }
        } catch (IteratorExit) {
            // IteratorExit shouldn't be noticed.
        } finally {
            $this->stream->close();
        }
    }
}
