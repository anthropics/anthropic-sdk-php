<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

use Anthropic\Core\Serde\CoerceState;
use Anthropic\Core\Serde\DumpState;

interface StaticConverter
{
    public static function coerce(mixed $value, CoerceState $state): mixed;

    public static function dump(mixed $value, DumpState $state): mixed;
}
