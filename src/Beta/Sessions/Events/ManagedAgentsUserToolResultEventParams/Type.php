<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams;

enum Type: string
{
    case USER_TOOL_RESULT = 'user.tool_result';
}
