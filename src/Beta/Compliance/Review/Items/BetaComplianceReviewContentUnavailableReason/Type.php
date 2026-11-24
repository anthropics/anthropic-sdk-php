<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewContentUnavailableReason;

enum Type: string
{
    case NOT_CAPTURED = 'not_captured';

    case STORED_COPY_UNAVAILABLE = 'stored_copy_unavailable';
}
