<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaCacheControlEphemeral;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class TTL implements ConverterSource
{
    use Enum;

    final public const TTL_5M = '5m';

    final public const TTL_1H = '1h';
}
