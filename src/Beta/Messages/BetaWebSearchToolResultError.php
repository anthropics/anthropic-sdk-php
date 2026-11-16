<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

// Loading the class registers this name as its alias.
class_exists(BetaWebSearchToolResultErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaWebSearchToolResultError has been renamed to BetaWebSearchToolResultErrorObject
     */
    class BetaWebSearchToolResultError extends BetaWebSearchToolResultErrorObject {}
}
