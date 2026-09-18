<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionListParams;

/**
 * SessionStatus enum.
 */
enum Status: string
{
    /**
     * Transient error occurred, retrying automatically.
     */
    case RESCHEDULING = 'rescheduling';

    /**
     * Agent is actively executing.
     */
    case RUNNING = 'running';

    /**
     * Agent is waiting for input, including user messages or tool confirmations. Sessions start in idle.
     */
    case IDLE = 'idle';

    /**
     * Session has ended, either due to an error or completion.
     */
    case TERMINATED = 'terminated';
}
