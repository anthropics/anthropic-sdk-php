<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseStatus;

enum Type: string
{
    case OPEN = 'open';

    case CLOSED = 'closed';
}
