<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionUpdatedEvent;

enum Type: string
{
    case SESSION_UPDATED = 'session.updated';
}
