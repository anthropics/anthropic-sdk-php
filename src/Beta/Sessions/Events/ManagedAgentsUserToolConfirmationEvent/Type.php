<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;

enum Type: string
{
    case USER_TOOL_CONFIRMATION = 'user.tool_confirmation';
}
