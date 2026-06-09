<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

/**
 * What triggered a deployment run.
 */
enum BetaManagedAgentsTriggerType: string
{
    case SCHEDULE = 'schedule';

    case MANUAL = 'manual';
}
