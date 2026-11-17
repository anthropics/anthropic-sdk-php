<?php

declare(strict_types=1);

namespace Anthropic;

// Loading the class registers this name as its alias.
class_exists(NotFoundErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated NotFoundError has been renamed to NotFoundErrorObject
     */
    class NotFoundError extends NotFoundErrorObject {}
}
