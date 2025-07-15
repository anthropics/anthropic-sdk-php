<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

final class BetaCodeExecutionToolResultErrorCode
{
    final public const INVALID_TOOL_INPUT = 'invalid_tool_input';

    final public const UNAVAILABLE = 'unavailable';

    final public const TOO_MANY_REQUESTS = 'too_many_requests';

    final public const EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';
}
