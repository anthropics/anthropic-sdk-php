<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
