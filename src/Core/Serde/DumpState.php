<?php

declare(strict_types=1);

namespace Anthropic\Core\Serde;

/**
 * @internal
 */
final class DumpState
{
    public function __construct(
        public bool $canRetry = true
    ) {}
}
