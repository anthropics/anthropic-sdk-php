<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests;

enum BetaSpendLimitIncreaseRequestStatus: string
{
    case APPROVED = 'approved';

    case DENIED = 'denied';

    case PENDING = 'pending';
}
