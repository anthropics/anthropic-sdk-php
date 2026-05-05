<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionListParams;

/**
 * SessionStatus enum.
 */
enum Status: string
{
    case RESCHEDULING = 'rescheduling';

    case RUNNING = 'running';

    case IDLE = 'idle';

    case TERMINATED = 'terminated';
}
