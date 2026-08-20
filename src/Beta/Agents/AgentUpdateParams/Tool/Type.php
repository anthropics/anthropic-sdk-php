<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\AgentUpdateParams\Tool;

enum Type: string
{
    case AGENT_TOOLSET_20260401 = 'agent_toolset_20260401';

    case MCP_TOOLSET = 'mcp_toolset';

    case CUSTOM = 'custom';
}
