<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedError\RetryStatus;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedErrorObject\RetryStatus\Type::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsCompactionLimitReachedError has been renamed to BetaManagedAgentsCompactionLimitReachedErrorObject
     */
    enum Type: string
    {
        case RETRYING = 'retrying';

        case EXHAUSTED = 'exhausted';

        case TERMINAL = 'terminal';
    }
}
