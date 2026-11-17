<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorObject;

enum ErrorCode: string
{
    case INVALID_TOOL_INPUT = 'invalid_tool_input';

    case UNAVAILABLE = 'unavailable';

    case TOO_MANY_REQUESTS = 'too_many_requests';

    case EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';

    case OUTPUT_FILE_TOO_LARGE = 'output_file_too_large';
}

class_alias(
    ErrorCode::class,
    'Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultError\ErrorCode',
);
