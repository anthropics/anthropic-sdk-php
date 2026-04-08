<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent;

enum Type: string
{
    case SESSION_STATUS_RUNNING = 'session.status_running';
}
