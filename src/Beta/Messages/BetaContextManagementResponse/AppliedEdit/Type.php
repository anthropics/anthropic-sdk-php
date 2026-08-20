<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementResponse\AppliedEdit;

enum Type: string
{
    case CLEAR_TOOL_USES_20250919 = 'clear_tool_uses_20250919';

    case CLEAR_THINKING_20251015 = 'clear_thinking_20251015';
}
