<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits;

/**
 * Rate limiter type.
 */
enum WorkspaceRateLimitType: string
{
    case FAST_ITPMCA = 'fast_itpmca';

    case FAST_OTPM = 'fast_otpm';

    case INPUT_TOKENS_PER_MINUTE = 'input_tokens_per_minute';

    case INPUT_TOKENS_PER_MINUTE_CACHE_AWARE = 'input_tokens_per_minute_cache_aware';

    case OUTPUT_TOKENS_PER_MINUTE = 'output_tokens_per_minute';

    case REQUESTS_PER_MINUTE = 'requests_per_minute';

    case TOKENS_PER_DAY = 'tokens_per_day';

    case TOKENS_PER_MINUTE = 'tokens_per_minute';

    case TOOL_USES_PER_SECOND = 'tool_uses_per_second';
}
