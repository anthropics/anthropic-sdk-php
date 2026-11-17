<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

// Loading the class registers this name as its alias.
class_exists(BetaBashCodeExecutionToolResultErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaBashCodeExecutionToolResultError has been renamed to BetaBashCodeExecutionToolResultErrorObject
     */
    class BetaBashCodeExecutionToolResultError extends BetaBashCodeExecutionToolResultErrorObject {}
}
