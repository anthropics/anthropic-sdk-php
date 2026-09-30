<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError\RetryStatus;

enum Type: string
{
    case RETRYING = 'retrying';

    case EXHAUSTED = 'exhausted';

    case TERMINAL = 'terminal';
}
