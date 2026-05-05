<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRescheduledEvent;

enum Type: string
{
    case SESSION_THREAD_STATUS_RESCHEDULED = 'session.thread_status_rescheduled';
}
