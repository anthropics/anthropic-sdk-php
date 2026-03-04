<?php

declare(strict_types=1);

namespace Anthropic\Messages;

/**
 * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
 */
enum Model: string
{
    case CLAUDE_OPUS_4_6 = 'claude-opus-4-6';

    case CLAUDE_SONNET_4_6 = 'claude-sonnet-4-6';

    case CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    case CLAUDE_HAIKU_4_5_20251001 = 'claude-haiku-4-5-20251001';

    case CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    case CLAUDE_OPUS_4_5_20251101 = 'claude-opus-4-5-20251101';

    case CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    case CLAUDE_SONNET_4_5_20250929 = 'claude-sonnet-4-5-20250929';

    case CLAUDE_OPUS_4_1 = 'claude-opus-4-1';

    case CLAUDE_OPUS_4_1_20250805 = 'claude-opus-4-1-20250805';

    case CLAUDE_OPUS_4_0 = 'claude-opus-4-0';

    case CLAUDE_OPUS_4_20250514 = 'claude-opus-4-20250514';

    case CLAUDE_SONNET_4_0 = 'claude-sonnet-4-0';

    case CLAUDE_SONNET_4_20250514 = 'claude-sonnet-4-20250514';

    case CLAUDE_3_HAIKU_20240307 = 'claude-3-haiku-20240307';
}
