<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaUsage;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * If the request used the priority, standard, or batch tier.
 *
 * @phpstan-type service_tier_alias = ServiceTier::*|null
 */
final class ServiceTier implements ConverterSource
{
    use Enum;

    final public const STANDARD = 'standard';

    final public const PRIORITY = 'priority';

    final public const BATCH = 'batch';
}
