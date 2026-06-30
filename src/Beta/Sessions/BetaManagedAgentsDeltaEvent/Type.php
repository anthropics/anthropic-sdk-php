<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;

enum Type: string
{
    case EVENT_DELTA = 'event_delta';
}
