<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsModelOverloadedErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ManagedAgentsModelOverloadedError has been renamed to ManagedAgentsModelOverloadedErrorObject
     */
    class ManagedAgentsModelOverloadedError extends ManagedAgentsModelOverloadedErrorObject {}
}
