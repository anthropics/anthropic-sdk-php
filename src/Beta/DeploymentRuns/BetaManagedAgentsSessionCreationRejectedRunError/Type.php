<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionCreationRejectedRunError;

enum Type: string
{
    case SESSION_CREATION_REJECTED_ERROR = 'session_creation_rejected_error';
}
