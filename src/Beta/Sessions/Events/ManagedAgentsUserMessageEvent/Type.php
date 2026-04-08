<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;

enum Type: string
{
    case USER_MESSAGE = 'user.message';
}
