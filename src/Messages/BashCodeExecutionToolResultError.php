<?php

declare(strict_types=1);

namespace Anthropic\Messages;

// Loading the class registers this name as its alias.
class_exists(BashCodeExecutionToolResultErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BashCodeExecutionToolResultError has been renamed to BashCodeExecutionToolResultErrorObject
     */
    class BashCodeExecutionToolResultError extends BashCodeExecutionToolResultErrorObject {}
}
