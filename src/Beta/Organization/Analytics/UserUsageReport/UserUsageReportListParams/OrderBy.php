<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;

/**
 * Metric to rank actors by. Defaults to `total_tokens`.
 */
enum OrderBy: string
{
    case OUTPUT_TOKENS = 'output_tokens';

    case REQUESTS = 'requests';

    case TOTAL_TOKENS = 'total_tokens';

    case UNCACHED_INPUT_TOKENS = 'uncached_input_tokens';
}
