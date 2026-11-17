<?php

declare(strict_types=1);

namespace Anthropic\Messages;

// Loading the class registers this name as its alias.
class_exists(ToolSearchToolResultErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated ToolSearchToolResultError has been renamed to ToolSearchToolResultErrorObject
     */
    class ToolSearchToolResultError extends ToolSearchToolResultErrorObject {}
}
