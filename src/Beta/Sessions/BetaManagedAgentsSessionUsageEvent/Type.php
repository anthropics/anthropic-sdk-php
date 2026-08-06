<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsageEvent;

enum Type: string
{
    case SESSION_USAGE = 'session.usage';
}
