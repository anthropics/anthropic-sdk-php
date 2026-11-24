<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

/**
 * The field that a list of review cases is sorted by: `created_at` or `updated_at`.
 */
enum BetaComplianceReviewCaseOrderBy: string
{
    /** Sort by when Anthropic sent the case. */
    case CREATED_AT = 'created_at';

    /** Sort by when the case last changed. */
    case UPDATED_AT = 'updated_at';
}
