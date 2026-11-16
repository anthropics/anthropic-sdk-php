<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

// Loading the class registers this name as its alias.
class_exists(BetaManagedAgentsEnvironmentNotFoundRunErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsEnvironmentNotFoundRunError has been renamed to BetaManagedAgentsEnvironmentNotFoundRunErrorObject
     */
    class BetaManagedAgentsEnvironmentNotFoundRunError extends BetaManagedAgentsEnvironmentNotFoundRunErrorObject {}
}
