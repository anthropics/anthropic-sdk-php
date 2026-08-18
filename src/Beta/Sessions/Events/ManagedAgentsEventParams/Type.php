<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams;

enum Type: string
{
    case USER_MESSAGE = 'user.message';

    case USER_INTERRUPT = 'user.interrupt';

    case USER_TOOL_CONFIRMATION = 'user.tool_confirmation';

    case USER_CUSTOM_TOOL_RESULT = 'user.custom_tool_result';

    case USER_DEFINE_OUTCOME = 'user.define_outcome';

    case USER_TOOL_RESULT = 'user.tool_result';

    case SYSTEM_MESSAGE = 'system.message';
}
