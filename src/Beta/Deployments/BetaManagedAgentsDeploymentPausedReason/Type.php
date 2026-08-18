<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReason;

enum Type: string
{
    case MANUAL = 'manual';

    case ERROR = 'error';
}
