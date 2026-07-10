<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

/**
 * Lifecycle status of a Dream.
 */
enum BetaDreamStatus: string
{
    case PENDING = 'pending';

    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';

    case CANCELED = 'canceled';
}
