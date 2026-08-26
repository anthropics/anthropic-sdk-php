<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams;

/**
 * Data residency geo. Only `us` is supported.
 */
enum Geo: string
{
    case US = 'us';
}
