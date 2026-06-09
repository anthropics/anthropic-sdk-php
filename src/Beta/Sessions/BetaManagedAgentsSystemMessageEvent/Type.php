<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent;

enum Type: string
{
    case SYSTEM_MESSAGE = 'system.message';
}
