<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaUsage;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class ServiceTier implements ConverterSource
{
    use Enum;

    final public const STANDARD = 'standard';

    final public const PRIORITY = 'priority';

    final public const BATCH = 'batch';
}
