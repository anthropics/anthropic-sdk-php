<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\BetaDreamInput;

enum Type: string
{
    case MEMORY_STORE = 'memory_store';

    case SESSIONS = 'sessions';
}
