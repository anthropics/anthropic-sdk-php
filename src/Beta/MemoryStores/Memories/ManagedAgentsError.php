<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsError has been renamed to BetaManagedAgentsErrorObject
     */
    class ManagedAgentsError extends ManagedAgentsErrorObject {}
}
