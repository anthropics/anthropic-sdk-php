<?php

declare(strict_types=1);

namespace Anthropic;

// Loading the class registers this name as its alias.
class_exists(InvalidRequestErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated InvalidRequestError has been renamed to InvalidRequestErrorObject
     */
    class InvalidRequestError extends InvalidRequestErrorObject {}
}
