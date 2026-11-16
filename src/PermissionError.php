<?php

declare(strict_types=1);

namespace Anthropic;

// Loading the class registers this name as its alias.
class_exists(PermissionErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated PermissionError has been renamed to PermissionErrorObject
     */
    class PermissionError extends PermissionErrorObject {}
}
