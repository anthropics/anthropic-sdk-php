<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

/**
 * The model that will power your agent.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
 */
enum BetaManagedAgentsModel: string
{
    case CLAUDE_OPUS_4_6 = 'claude-opus-4-6';

    case CLAUDE_SONNET_4_6 = 'claude-sonnet-4-6';

    case CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    case CLAUDE_HAIKU_4_5_20251001 = 'claude-haiku-4-5-20251001';

    case CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    case CLAUDE_OPUS_4_5_20251101 = 'claude-opus-4-5-20251101';

    case CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    case CLAUDE_SONNET_4_5_20250929 = 'claude-sonnet-4-5-20250929';
}
