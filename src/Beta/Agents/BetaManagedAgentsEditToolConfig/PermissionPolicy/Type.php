<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfig\PermissionPolicy;

enum Type: string
{
    case ALWAYS_ALLOW = 'always_allow';

    case ALWAYS_ASK = 'always_ask';
}
