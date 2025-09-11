<?php

declare(strict_types=1);

namespace Anthropic\Messages\CacheControlEphemeral;

/**
 * The time-to-live for the cache control breakpoint.
 *
 * This may be one the following values:
 * - `5m`: 5 minutes
 * - `1h`: 1 hour
 *
 * Defaults to `5m`.
 */
enum TTL: string
{
    case TTL_5M = '5m';

    case TTL_1H = '1h';
}
