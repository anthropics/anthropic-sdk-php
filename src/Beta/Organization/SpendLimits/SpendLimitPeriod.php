<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

enum SpendLimitPeriod: string
{
    case DAILY = 'daily';

    case MONTHLY = 'monthly';

    case WEEKLY = 'weekly';
}
