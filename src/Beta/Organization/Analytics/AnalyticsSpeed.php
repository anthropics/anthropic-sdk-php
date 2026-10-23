<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsSpeed: string
{
    case FAST = 'fast';

    case STANDARD = 'standard';
}
