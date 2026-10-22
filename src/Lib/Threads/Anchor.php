<?php

declare(strict_types=1);

namespace Anthropic\Lib\Threads;

/**
 * The thread on the API that the next turn continues.
 *
 * @internal
 */
final class Anchor
{
    /**
     * @param array{system: string, tools: string} $createdWith the `system` and `tools` that the thread was created with, as JSON
     * @param bool $createdAfterNotFound whether the thread was created because the API did not find the one before it, and no turn has continued it yet
     */
    public function __construct(
        public readonly string $previousMessageId,
        public readonly array $createdWith,
        public readonly bool $createdAfterNotFound,
    ) {}
}
