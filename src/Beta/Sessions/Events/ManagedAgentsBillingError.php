<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsBillingErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ManagedAgentsBillingError has been renamed to ManagedAgentsBillingErrorObject
     */
    class ManagedAgentsBillingError extends ManagedAgentsBillingErrorObject {}
}
