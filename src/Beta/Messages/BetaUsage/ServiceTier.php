<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaUsage;

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

    public const STANDARD = 'standard';

    public const PRIORITY = 'priority';

    public const BATCH = 'batch';
}
