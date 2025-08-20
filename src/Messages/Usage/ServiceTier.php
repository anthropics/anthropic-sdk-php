<?php

declare(strict_types=1);

namespace Anthropic\Messages\Usage;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * If the request used the priority, standard, or batch tier.
 *
 * @phpstan-type service_tier_alias = ServiceTier::*|null
 */
final class ServiceTier implements ConverterSource
{
    use SdkEnum;

    public const STANDARD = 'standard';

    public const PRIORITY = 'priority';

    public const BATCH = 'batch';
}
