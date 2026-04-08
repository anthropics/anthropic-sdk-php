<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError;

enum Type: string
{
    case MCP_AUTHENTICATION_FAILED_ERROR = 'mcp_authentication_failed_error';
}
