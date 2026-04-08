<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent;

enum Type: string
{
    case AGENT_TOOL_USE = 'agent.tool_use';
}
