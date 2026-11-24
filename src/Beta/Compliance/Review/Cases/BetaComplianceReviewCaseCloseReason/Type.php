<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseCloseReason;

/**
 * `responded` means that Anthropic recorded a response. `window_ended` means that the time to respond ended with no response. `ended_by_anthropic` means that Anthropic ended the case before that time was over. New values can appear, so accept a value that you don't know.
 */
enum Type: string
{
    case RESPONDED = 'responded';

    case WINDOW_ENDED = 'window_ended';

    case ENDED_BY_ANTHROPIC = 'ended_by_anthropic';
}
