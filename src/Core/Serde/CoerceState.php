<?php

declare(strict_types=1);

namespace Anthropic\Core\Serde;

/**
 * @internal
 */
final class CoerceState
{
    public function __construct(
        public bool $translateNames = true,
        public int $yes = 0,
        public int $no = 0,
        public int $maybe = 0,
        public int $branched = 0,
    ) {}
}
