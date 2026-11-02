<?php

declare(strict_types=1);

namespace Anthropic\Organization\SpendLimits\IncreaseRequests;

enum SpendLimitIncreaseRequestStatus: string
{
    case APPROVED = 'approved';

    case DENIED = 'denied';

    case PENDING = 'pending';
}
