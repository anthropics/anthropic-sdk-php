<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent;

enum Type: string
{
    case AGENT_MCP_TOOL_USE = 'agent.mcp_tool_use';
}
