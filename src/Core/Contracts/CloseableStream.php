<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

/**
 * @template TInner
 *
 * @extends \IteratorAggregate<int,TInner>
 */
interface CloseableStream extends \IteratorAggregate
{
    /**
     * Manually force the stream to close early.
     * Iterating through will automatically close as well.
     */
    public function close(): void;
}
