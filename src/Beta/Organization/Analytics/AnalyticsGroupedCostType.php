<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsGroupedCostType: string
{
    case CODE_EXECUTION = 'code_execution';

    case SESSION_USAGE = 'session_usage';

    case TOKENS = 'tokens';

    case WEB_SEARCH = 'web_search';
}
