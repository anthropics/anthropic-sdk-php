<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

/**
 * Lifecycle status of a deployment.
 */
enum BetaManagedAgentsDeploymentStatus: string
{
    /**
     * The deployment is active and can run sessions. Archived deployments also report this status; check `archived_at` to distinguish them.
     */
    case ACTIVE = 'active';

    /**
     * The deployment is paused. Autonomous triggers are suppressed; manual runs are still permitted.
     */
    case PAUSED = 'paused';
}
