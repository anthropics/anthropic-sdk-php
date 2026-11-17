<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

// Loading the class registers this name as its alias.
class_exists(BetaDreamErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaDreamError has been renamed to BetaDreamErrorObject
     */
    class BetaDreamError extends BetaDreamErrorObject {}
}
