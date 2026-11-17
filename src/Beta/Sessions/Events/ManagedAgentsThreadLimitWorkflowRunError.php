<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

// Loading the class registers this name as its alias.
class_exists(ManagedAgentsThreadLimitWorkflowRunErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ManagedAgentsThreadLimitWorkflowRunError has been renamed to ManagedAgentsThreadLimitWorkflowRunErrorObject
     */
    class ManagedAgentsThreadLimitWorkflowRunError extends ManagedAgentsThreadLimitWorkflowRunErrorObject {}
}
