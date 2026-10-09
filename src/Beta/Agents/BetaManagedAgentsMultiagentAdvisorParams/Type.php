<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorParams;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
