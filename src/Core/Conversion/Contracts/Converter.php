<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion\Contracts;

use Anthropic\Core\Conversion\CoerceState;
use Anthropic\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
