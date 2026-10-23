<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsUsageCostInferenceGeo: string
{
    case GLOBAL = 'global';

    case US = 'us';
}
