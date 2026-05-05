<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads;

/**
 * SessionThreadStatus enum.
 */
enum ManagedAgentsSessionThreadStatus: string
{
    case RUNNING = 'running';

    case IDLE = 'idle';

    case RESCHEDULING = 'rescheduling';

    case TERMINATED = 'terminated';
}
