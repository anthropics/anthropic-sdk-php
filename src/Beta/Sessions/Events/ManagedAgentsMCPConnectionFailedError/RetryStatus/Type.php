<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\RetryStatus;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject\RetryStatus\Type::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaManagedAgentsMCPConnectionFailedError has been renamed to BetaManagedAgentsMCPConnectionFailedErrorObject
     */
    enum Type: string
    {
        case RETRYING = 'retrying';

        case EXHAUSTED = 'exhausted';

        case TERMINAL = 'terminal';
    }
}
