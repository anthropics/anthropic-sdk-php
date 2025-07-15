<?php

declare(strict_types=1);

namespace Anthropic\Models\WebSearchToolResultError;

class ErrorCode
{
    final public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    final public const UNAVAILABLE = 'unavailable';

    final public const MAX_USES_EXCEEDED = 'max_uses_exceeded';

    final public const TOO_MANY_REQUESTS = 'too_many_requests';

    final public const QUERY_TOO_LONG = 'query_too_long';
}
