<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusTerminatedEvent;

enum Type: string
{
    case SESSION_THREAD_STATUS_TERMINATED = 'session.thread_status_terminated';
}
