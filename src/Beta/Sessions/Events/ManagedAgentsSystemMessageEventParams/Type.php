<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSystemMessageEventParams;

enum Type: string
{
    case SYSTEM_MESSAGE = 'system.message';
}
