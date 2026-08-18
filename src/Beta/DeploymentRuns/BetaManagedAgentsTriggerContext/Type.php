<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsTriggerContext;

enum Type: string
{
    case SCHEDULE = 'schedule';

    case MANUAL = 'manual';
}
