<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent;

enum Type: string
{
    case AGENT_MCP_TOOL_RESULT = 'agent.mcp_tool_result';
}
