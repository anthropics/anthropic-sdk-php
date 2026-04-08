<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent;

enum Type: string
{
    case SESSION_STATUS_TERMINATED = 'session.status_terminated';
}
