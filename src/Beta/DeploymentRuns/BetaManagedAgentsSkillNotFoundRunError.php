<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

// Loading the class registers this name as its alias.
class_exists(BetaManagedAgentsSkillNotFoundRunErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsSkillNotFoundRunError has been renamed to BetaManagedAgentsSkillNotFoundRunErrorObject
     */
    class BetaManagedAgentsSkillNotFoundRunError extends BetaManagedAgentsSkillNotFoundRunErrorObject {}
}
