<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class Type implements ConverterSource
{
    use Enum;

    final public const CUSTOM = 'custom';
}
