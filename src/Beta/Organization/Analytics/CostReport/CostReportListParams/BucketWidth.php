<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams;

/**
 * Time bucket granularity.
 */
enum BucketWidth: string
{
    case DAY = '1d';

    case HOUR = '1h';

    case MINUTE = '1m';
}
