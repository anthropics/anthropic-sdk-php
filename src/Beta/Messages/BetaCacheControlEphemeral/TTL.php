<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCacheControlEphemeral;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The time-to-live for the cache control breakpoint.
 *
 * This may be one the following values:
 * - `5m`: 5 minutes
 * - `1h`: 1 hour
 *
 * Defaults to `5m`.
 */
final class TTL implements ConverterSource
{
    use SdkEnum;

    public const TTL_5M = '5m';

    public const TTL_1H = '1h';
}
