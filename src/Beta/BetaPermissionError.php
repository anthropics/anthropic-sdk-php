<?php

declare(strict_types=1);

namespace Anthropic\Beta;

// Loading the class registers this name as its alias.
class_exists(BetaPermissionErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaPermissionError has been renamed to BetaPermissionErrorObject
     */
    class BetaPermissionError extends BetaPermissionErrorObject {}
}
