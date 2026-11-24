<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

/**
 * A conclusion on flagged messages: `violation` or `no_violation`.
 */
enum BetaComplianceReviewDetermination: string
{
    /** The messages violated a policy. */
    case VIOLATION = 'violation';

    /** The messages violated no policy. */
    case NO_VIOLATION = 'no_violation';
}
