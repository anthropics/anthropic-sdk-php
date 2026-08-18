<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestToolRemovalBlock\Tool;

enum Type: string
{
    case TOOL_REFERENCE = 'tool_reference';

    case MCP_TOOL_REFERENCE = 'mcp_tool_reference';

    case MCP_TOOLSET_REFERENCE = 'mcp_toolset_reference';
}
