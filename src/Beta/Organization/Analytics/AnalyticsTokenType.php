<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsTokenType: string
{
    case CACHE_CREATION_EPHEMERAL_1H_INPUT_TOKENS = 'cache_creation.ephemeral_1h_input_tokens';

    case CACHE_CREATION_EPHEMERAL_5M_INPUT_TOKENS = 'cache_creation.ephemeral_5m_input_tokens';

    case CACHE_READ_INPUT_TOKENS = 'cache_read_input_tokens';

    case OUTPUT_TOKENS = 'output_tokens';

    case UNCACHED_INPUT_TOKENS = 'uncached_input_tokens';
}
