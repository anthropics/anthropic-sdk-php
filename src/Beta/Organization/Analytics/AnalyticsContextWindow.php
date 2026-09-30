<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsContextWindow: string
{
    case FROM_0_TO_200K = '0-200k';

    case FROM_200K_TO_1_M = '200k-1M';
}
