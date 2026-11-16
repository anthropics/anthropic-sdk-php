<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsRepositoryCheckoutErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsRepositoryCheckoutError has been renamed to BetaManagedAgentsRepositoryCheckoutErrorObject
     */
    class ManagedAgentsRepositoryCheckoutError extends ManagedAgentsRepositoryCheckoutErrorObject {}
}
