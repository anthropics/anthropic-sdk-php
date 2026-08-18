<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementConfig\Edit;

enum Type: string
{
    case CLEAR_TOOL_USES_20250919 = 'clear_tool_uses_20250919';

    case CLEAR_THINKING_20251015 = 'clear_thinking_20251015';

    case COMPACT_20260112 = 'compact_20260112';
}
