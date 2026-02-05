<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

enum BetaStopReason: string
{
    case END_TURN = 'end_turn';

    case MAX_TOKENS = 'max_tokens';

    case STOP_SEQUENCE = 'stop_sequence';

    case TOOL_USE = 'tool_use';

    case PAUSE_TURN = 'pause_turn';

    case COMPACTION = 'compaction';

    case REFUSAL = 'refusal';

    case MODEL_CONTEXT_WINDOW_EXCEEDED = 'model_context_window_exceeded';
}
