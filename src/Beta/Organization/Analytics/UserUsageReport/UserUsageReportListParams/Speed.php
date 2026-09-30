<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;

enum Speed: string
{
    case FAST = 'fast';

    case STANDARD = 'standard';
}
