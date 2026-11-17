<?php

declare(strict_types=1);

namespace Anthropic;

// Loading the class registers this name as its alias.
class_exists(AuthenticationErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated AuthenticationError has been renamed to AuthenticationErrorObject
     */
    class AuthenticationError extends AuthenticationErrorObject {}
}
