<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;

/**
 * Sort direction. Defaults to `desc`.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
