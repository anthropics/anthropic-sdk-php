<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams;

enum Type: string
{
    case USER_MESSAGE = 'user.message';
}
