<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

// Loading the class registers this name as its alias.
class_exists(BetaDreamingErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaDreamingError has been renamed to BetaDreamingErrorObject
     */
    class BetaDreamingError extends BetaDreamingErrorObject {}
}
