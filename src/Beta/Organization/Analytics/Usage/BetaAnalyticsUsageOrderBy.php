<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Usage;

enum BetaAnalyticsUsageOrderBy: string
{
    case OUTPUT_TOKENS = 'output_tokens';

    case REQUESTS = 'requests';

    case TIME = 'time';

    case TOTAL_TOKENS = 'total_tokens';

    case UNCACHED_INPUT_TOKENS = 'uncached_input_tokens';
}
