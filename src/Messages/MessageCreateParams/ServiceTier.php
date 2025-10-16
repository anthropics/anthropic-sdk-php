<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageCreateParams;

/**
 * Determines whether to use priority capacity (if available) or standard capacity for this request.
 *
 * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
 */
enum ServiceTier: string
{
    case AUTO = 'auto';

    case STANDARD_ONLY = 'standard_only';
}
