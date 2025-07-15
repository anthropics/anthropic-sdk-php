<?php

declare(strict_types=1);

namespace Anthropic\Models;

final class StopReason
{
    final public const END_TURN = 'end_turn';

    final public const MAX_TOKENS = 'max_tokens';

    final public const STOP_SEQUENCE = 'stop_sequence';

    final public const TOOL_USE = 'tool_use';

    final public const PAUSE_TURN = 'pause_turn';

    final public const REFUSAL = 'refusal';
}
