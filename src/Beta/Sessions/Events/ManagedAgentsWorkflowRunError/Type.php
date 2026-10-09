<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError;

enum Type: string
{
    case TIMEOUT_ERROR = 'timeout_error';

    case PROGRAM_ERROR = 'program_error';

    case UNKNOWN_ERROR = 'unknown_error';

    case THREAD_LIMIT_ERROR = 'thread_limit_error';

    case MAX_WORKFLOW_RUNS_ERROR = 'max_workflow_runs_error';
}
