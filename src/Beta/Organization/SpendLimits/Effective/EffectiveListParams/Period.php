<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\Effective\EffectiveListParams;

enum Period: string
{
    case DAILY = 'daily';

    case MONTHLY = 'monthly';

    case WEEKLY = 'weekly';
}
