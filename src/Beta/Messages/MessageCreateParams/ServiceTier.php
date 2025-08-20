<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\MessageCreateParams;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Determines whether to use priority capacity (if available) or standard capacity for this request.
 *
 * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.anthropic.com/en/api/service-tiers) for details.
 *
 * @phpstan-type service_tier_alias = ServiceTier::*
 */
final class ServiceTier implements ConverterSource
{
    use SdkEnum;

    public const AUTO = 'auto';

    public const STANDARD_ONLY = 'standard_only';
}
