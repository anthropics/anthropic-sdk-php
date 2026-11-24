<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNoticeKind;

/**
 * `response_requested` asks you to respond to the cases in `case_ids`. For `warning` and `question`, `message` explains how to answer if an answer is needed. New values can appear, so accept a value that you don't know.
 */
enum Type: string
{
    case RESPONSE_REQUESTED = 'response_requested';

    case WARNING = 'warning';

    case QUESTION = 'question';
}
