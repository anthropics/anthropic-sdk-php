<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work\SelfHostedWork;

/**
 * Current state of the work item.
 */
enum State: string
{
    case QUEUED = 'queued';

    case STARTING = 'starting';

    case ACTIVE = 'active';

    case STOPPING = 'stopping';

    case STOPPED = 'stopped';
}
