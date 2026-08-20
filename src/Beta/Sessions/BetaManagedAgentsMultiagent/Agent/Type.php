<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsMultiagent\Agent;

enum Type: string
{
    case AGENT = 'agent';

    case ADVISOR = 'advisor';
}
