<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

/**
 * What triggered a deployment run.
 */
enum BetaManagedAgentsTriggerType: string
{
    /**
     * The run was fired by the deployment's cron schedule.
     */
    case SCHEDULE = 'schedule';

    /**
     * The run was started manually by creating a session directly against the deployment.
     */
    case MANUAL = 'manual';
}
