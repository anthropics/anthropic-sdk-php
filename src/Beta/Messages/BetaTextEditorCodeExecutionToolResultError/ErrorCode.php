<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultError;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorObject\ErrorCode::class,
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaTextEditorCodeExecutionToolResultError has been renamed to BetaTextEditorCodeExecutionToolResultErrorObject
     */
    enum ErrorCode: string
    {
        case INVALID_TOOL_INPUT = 'invalid_tool_input';

        case UNAVAILABLE = 'unavailable';

        case TOO_MANY_REQUESTS = 'too_many_requests';

        case EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';

        case FILE_NOT_FOUND = 'file_not_found';
    }
}
