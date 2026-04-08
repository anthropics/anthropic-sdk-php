<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError;

enum Type: string
{
    case MCP_CONNECTION_FAILED_ERROR = 'mcp_connection_failed_error';
}
