<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth;

enum Type: string
{
    case MCP_OAUTH = 'mcp_oauth';

    case STATIC_BEARER = 'static_bearer';

    case ENVIRONMENT_VARIABLE = 'environment_variable';
}
