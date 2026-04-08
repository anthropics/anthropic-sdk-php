<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusTerminal;

enum Type: string
{
    case TERMINAL = 'terminal';
}
