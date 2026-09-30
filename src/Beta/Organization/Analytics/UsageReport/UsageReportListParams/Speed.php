<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams;

enum Speed: string
{
    case FAST = 'fast';

    case STANDARD = 'standard';
}
