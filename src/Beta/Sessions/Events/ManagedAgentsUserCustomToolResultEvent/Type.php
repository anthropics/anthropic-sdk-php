<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;

enum Type: string
{
    case USER_CUSTOM_TOOL_RESULT = 'user.custom_tool_result';
}
