<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

/**
 * Lifecycle status of a deployment.
 */
enum BetaManagedAgentsDeploymentStatus: string
{
    case ACTIVE = 'active';

    case PAUSED = 'paused';
}
