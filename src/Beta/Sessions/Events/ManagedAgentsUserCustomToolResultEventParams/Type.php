<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams;

enum Type: string
{
    case USER_CUSTOM_TOOL_RESULT = 'user.custom_tool_result';
}
