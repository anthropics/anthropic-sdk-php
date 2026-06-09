<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionRateLimitedRunError;

enum Type: string
{
    case SESSION_RATE_LIMITED_ERROR = 'session_rate_limited_error';
}
