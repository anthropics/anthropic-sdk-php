<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

use Anthropic\Core\Serde\CoerceState;
use Anthropic\Core\Serde\DumpState;

interface Converter
{
    public function coerce(mixed $value, CoerceState $state): mixed;

    public function dump(mixed $value, DumpState $state): mixed;
}
