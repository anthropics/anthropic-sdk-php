<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;

enum Type: string
{
    case SESSION_STATUS_IDLE = 'session.status_idle';
}
