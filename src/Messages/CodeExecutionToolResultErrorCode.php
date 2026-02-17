<?php

declare(strict_types=1);

namespace Anthropic\Messages;

enum CodeExecutionToolResultErrorCode: string
{
    case INVALID_TOOL_INPUT = 'invalid_tool_input';

    case UNAVAILABLE = 'unavailable';

    case TOO_MANY_REQUESTS = 'too_many_requests';

    case EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';
}
