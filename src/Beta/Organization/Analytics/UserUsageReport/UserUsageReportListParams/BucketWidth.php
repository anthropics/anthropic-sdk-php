<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;

/**
 * Time-bucket granularity. When set, each row's `starting_at` and `ending_at` are populated and one actor may span several rows (one per time bucket with usage). The time bucket counts toward `limit`, so one page can return multiple rows for the same actor. `ending_at` is required when `bucket_width` is set, and with `bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the full `[starting_at, ending_at)` range.
 */
enum BucketWidth: string
{
    case DAY = '1d';

    case HOUR = '1h';

    case MINUTE = '1m';
}
