<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\MessageCreateParam;

use Anthropic\Core\Concerns\Enum;
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
    use Enum;

    final public const AUTO = 'auto';

    final public const STANDARD_ONLY = 'standard_only';
}
