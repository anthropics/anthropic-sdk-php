<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsServiceTier: string
{
    case BATCH = 'batch';

    case FLEX = 'flex';

    case FLEX_DISCOUNT = 'flex_discount';

    case PRIORITY = 'priority';

    case PRIORITY_ON_DEMAND = 'priority_on_demand';

    case STANDARD = 'standard';
}
