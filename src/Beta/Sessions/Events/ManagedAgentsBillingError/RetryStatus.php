<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingErrorObject\RetryStatus::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsBillingError has been renamed to BetaManagedAgentsBillingErrorObject
     */
    class RetryStatus extends \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingErrorObject\RetryStatus {}
}
