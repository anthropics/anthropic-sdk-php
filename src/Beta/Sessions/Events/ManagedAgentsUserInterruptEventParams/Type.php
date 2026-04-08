<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEventParams;

enum Type: string
{
    case USER_INTERRUPT = 'user.interrupt';
}
