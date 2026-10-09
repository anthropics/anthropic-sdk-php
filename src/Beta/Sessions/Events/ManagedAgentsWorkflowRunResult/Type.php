<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResult;

enum Type: string
{
    case COMPLETED = 'completed';

    case ERROR = 'error';

    case STOPPED = 'stopped';
}
