<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRunningEvent;

enum Type: string
{
    case SESSION_THREAD_STATUS_RUNNING = 'session.thread_status_running';
}
