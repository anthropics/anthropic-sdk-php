<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams\PermissionPolicy;

enum Type: string
{
    case ALWAYS_ALLOW = 'always_allow';

    case ALWAYS_ASK = 'always_ask';
}
