<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger;

enum Type: string
{
    case INPUT_TOKENS = 'input_tokens';

    case TOOL_USES = 'tool_uses';
}
