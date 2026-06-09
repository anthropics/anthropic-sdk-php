<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentNotFoundRunError;

enum Type: string
{
    case ENVIRONMENT_NOT_FOUND_ERROR = 'environment_not_found_error';
}
