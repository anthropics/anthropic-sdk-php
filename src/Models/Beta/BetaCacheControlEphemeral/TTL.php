<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaCacheControlEphemeral;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class TTL implements StaticConverter
{
    use Enum;

    final public const TTL_5M = '5m';

    final public const TTL_1H = '1h';
}
