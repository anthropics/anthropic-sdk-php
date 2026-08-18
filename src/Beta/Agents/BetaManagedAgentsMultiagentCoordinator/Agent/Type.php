<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Agent;

enum Type: string
{
    case AGENT = 'agent';

    case ADVISOR = 'advisor';
}
