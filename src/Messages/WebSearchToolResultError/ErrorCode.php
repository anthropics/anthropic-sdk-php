<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchToolResultError;

enum ErrorCode: string
{
    case INVALID_TOOL_INPUT = 'invalid_tool_input';

    case UNAVAILABLE = 'unavailable';

    case MAX_USES_EXCEEDED = 'max_uses_exceeded';

    case TOO_MANY_REQUESTS = 'too_many_requests';

    case QUERY_TOO_LONG = 'query_too_long';
}
