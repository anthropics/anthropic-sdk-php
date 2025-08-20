<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTool;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type type_alias = Type::*|null
 */
final class Type implements ConverterSource
{
    use SdkEnum;

    public const CUSTOM = 'custom';
}
