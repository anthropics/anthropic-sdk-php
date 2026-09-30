<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams;

enum Speed: string
{
    case FAST = 'fast';

    case STANDARD = 'standard';
}
