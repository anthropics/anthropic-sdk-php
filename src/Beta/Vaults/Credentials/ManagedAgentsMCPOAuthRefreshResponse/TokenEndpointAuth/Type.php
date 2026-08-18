<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse\TokenEndpointAuth;

enum Type: string
{
    case NONE = 'none';

    case CLIENT_SECRET_BASIC = 'client_secret_basic';

    case CLIENT_SECRET_POST = 'client_secret_post';
}
