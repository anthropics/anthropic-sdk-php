<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type stop_reason_alias = StopReason::*
 */
final class StopReason implements ConverterSource
{
    use Enum;

    public const END_TURN = 'end_turn';

    public const MAX_TOKENS = 'max_tokens';

    public const STOP_SEQUENCE = 'stop_sequence';

    public const TOOL_USE = 'tool_use';

    public const PAUSE_TURN = 'pause_turn';

    public const REFUSAL = 'refusal';
}
