<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaAdvisorToolResultError;

// Loading the class registers this name as its alias.
class_exists(
    \Anthropic\Beta\Messages\BetaAdvisorToolResultErrorObject\ErrorCode::class
);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated BetaAdvisorToolResultError has been renamed to BetaAdvisorToolResultErrorObject
     */
    enum ErrorCode: string
    {
        case MAX_USES_EXCEEDED = 'max_uses_exceeded';

        case PROMPT_TOO_LONG = 'prompt_too_long';

        case TOO_MANY_REQUESTS = 'too_many_requests';

        case OVERLOADED = 'overloaded';

        case UNAVAILABLE = 'unavailable';

        case EXECUTION_TIME_EXCEEDED = 'execution_time_exceeded';

        case MODEL_NOT_FOUND = 'model_not_found';
    }
}
