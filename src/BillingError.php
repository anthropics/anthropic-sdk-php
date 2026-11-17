<?php

declare(strict_types=1);

namespace Anthropic;

// Loading the class registers this name as its alias.
class_exists(BillingErrorObject::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BillingError has been renamed to BillingErrorObject
     */
    class BillingError extends BillingErrorObject {}
}
