<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsModelRateLimitedErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ManagedAgentsModelRateLimitedError has been renamed to ManagedAgentsModelRateLimitedErrorObject
     */
    class ManagedAgentsModelRateLimitedError extends ManagedAgentsModelRateLimitedErrorObject {}
}
