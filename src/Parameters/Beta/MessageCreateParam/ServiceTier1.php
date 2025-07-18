<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\MessageCreateParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class ServiceTier implements ConverterSource
{
    use Enum;

    final public const AUTO = 'auto';

    final public const STANDARD_ONLY = 'standard_only';
}
