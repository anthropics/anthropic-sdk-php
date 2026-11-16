<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsMCPConnectionFailedError has been renamed to BetaManagedAgentsMCPConnectionFailedErrorObject
     */
    class RetryStatus extends \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus {}
}
