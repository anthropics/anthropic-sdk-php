<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaAdvisorToolResultErrorParam;

enum ErrorCode: string
{
    case MAX_USES_EXCEEDED = 'max_uses_exceeded';

    case PROMPT_TOO_LONG = 'prompt_too_long';

    case TOO_MANY_REQUESTS = 'too_many_requests';

    case OVERLOADED = 'overloaded';

    case UNAVAILABLE = 'unavailable';

    case EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';
}
