<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent;

enum Type: string
{
    case SESSION_STATUS_RESCHEDULED = 'session.status_rescheduled';
}
