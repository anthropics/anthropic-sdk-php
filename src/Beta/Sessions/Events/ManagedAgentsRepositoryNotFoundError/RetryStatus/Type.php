<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryNotFoundError\RetryStatus;

enum Type: string
{
    case RETRYING = 'retrying';

    case EXHAUSTED = 'exhausted';

    case TERMINAL = 'terminal';
}
