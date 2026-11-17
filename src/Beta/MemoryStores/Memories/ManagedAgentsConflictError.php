<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsConflictErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ManagedAgentsConflictError has been renamed to ManagedAgentsConflictErrorObject
     */
    class ManagedAgentsConflictError extends ManagedAgentsConflictErrorObject {}
}
