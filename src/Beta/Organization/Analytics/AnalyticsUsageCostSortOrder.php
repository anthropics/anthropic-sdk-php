<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsUsageCostSortOrder: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
