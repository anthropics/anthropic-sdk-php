<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaTool;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type type_alias = Type::*|null
 */
final class Type implements ConverterSource
{
    use Enum;

    public const CUSTOM = 'custom';
}
