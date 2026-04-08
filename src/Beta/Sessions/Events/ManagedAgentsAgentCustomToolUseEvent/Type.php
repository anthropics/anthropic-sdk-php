<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent;

enum Type: string
{
    case AGENT_CUSTOM_TOOL_USE = 'agent.custom_tool_use';
}
