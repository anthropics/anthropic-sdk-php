<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

/**
 * A review case status to filter by: `open` or `closed`.
 */
enum BetaComplianceReviewCaseStatusFilter: string
{
    /** Cases that Anthropic is waiting for a response to. */
    case OPEN = 'open';

    /** Cases that Anthropic has stopped waiting on. */
    case CLOSED = 'closed';
}
