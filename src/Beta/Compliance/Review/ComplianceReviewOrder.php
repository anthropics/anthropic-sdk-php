<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review;

/**
 * A sort direction: `asc` or `desc`.
 */
enum ComplianceReviewOrder: string
{
    /** Oldest first. */
    case ASC = 'asc';

    /** Newest first. */
    case DESC = 'desc';
}
