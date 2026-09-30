<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsCostType: string
{
    case CODE_EXECUTION = 'code_execution';

    case TOKENS = 'tokens';

    case WEB_SEARCH = 'web_search';
}
