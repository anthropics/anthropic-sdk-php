<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenErrorObject\RetryStatus::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsRepositoryForbiddenError has been renamed to BetaManagedAgentsRepositoryForbiddenErrorObject
     */
    class RetryStatus extends \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenErrorObject\RetryStatus {}
}
