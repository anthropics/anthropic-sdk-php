<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentParams;

enum Type: string
{
    case COORDINATOR = 'coordinator';

    case MULTIAGENT_20261001 = 'multiagent_20261001';
}
