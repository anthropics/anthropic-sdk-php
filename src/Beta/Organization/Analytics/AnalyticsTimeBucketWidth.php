<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsTimeBucketWidth: string
{
    case DAY = '1d';

    case HOUR = '1h';

    case MINUTE = '1m';
}
