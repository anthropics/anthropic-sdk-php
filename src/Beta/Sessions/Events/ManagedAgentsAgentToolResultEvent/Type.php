<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent;

enum Type: string
{
    case AGENT_TOOL_RESULT = 'agent.tool_result';
}
