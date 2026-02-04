<?php

declare(strict_types=1);

namespace Anthropic\Messages;

/**
 * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
 *
 * @see https://platform.claude.com/docs/en/build-with-claude/claude-on-amazon-bedrock AWS Bedrock model identifiers
 * @see https://platform.claude.com/docs/en/build-with-claude/claude-on-vertex-ai List of supported Vertex AI models
 */
enum Model: string
{
    // Anthropic model identifiers

    case CLAUDE_OPUS_4_5_20251101 = 'claude-opus-4-5-20251101';

    case CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    case CLAUDE_3_7_SONNET_LATEST = 'claude-3-7-sonnet-latest';

    case CLAUDE_3_7_SONNET_20250219 = 'claude-3-7-sonnet-20250219';

    /**
     * @deprecated Model is deprecated. Migrate to claude-haiku-4-5-20251001.
     */
    case CLAUDE_3_5_HAIKU_LATEST = 'claude-3-5-haiku-latest';

    /**
     * @deprecated Model is deprecated. Migrate to claude-haiku-4-5-20251001.
     */
    case CLAUDE_3_5_HAIKU_20241022 = 'claude-3-5-haiku-20241022';

    case CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    case CLAUDE_HAIKU_4_5_20251001 = 'claude-haiku-4-5-20251001';

    case CLAUDE_SONNET_4_20250514 = 'claude-sonnet-4-20250514';

    case CLAUDE_SONNET_4_0 = 'claude-sonnet-4-0';

    case CLAUDE_4_SONNET_20250514 = 'claude-4-sonnet-20250514';

    case CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    case CLAUDE_SONNET_4_5_20250929 = 'claude-sonnet-4-5-20250929';

    case CLAUDE_OPUS_4_0 = 'claude-opus-4-0';

    case CLAUDE_OPUS_4_20250514 = 'claude-opus-4-20250514';

    case CLAUDE_4_OPUS_20250514 = 'claude-4-opus-20250514';

    case CLAUDE_OPUS_4_1_20250805 = 'claude-opus-4-1-20250805';

    case CLAUDE_3_OPUS_LATEST = 'claude-3-opus-latest';

    case CLAUDE_3_OPUS_20240229 = 'claude-3-opus-20240229';

    case CLAUDE_3_HAIKU_20240307 = 'claude-3-haiku-20240307';

    // AWS Bedrock model identifiers

    case BEDROCK_CLAUDE_SONNET_4_5_20250929 = 'anthropic.claude-sonnet-4-5-20250929-v1:0';

    case BEDROCK_CLAUDE_SONNET_4_20250514 = 'anthropic.claude-sonnet-4-20250514-v1:0';

    /**
     * @deprecated Model is deprecated. Migrate to anthropic.claude-sonnet-4-20250514-v1:0.
     */
    case BEDROCK_CLAUDE_3_7_SONNET_20250219 = 'anthropic.claude-3-7-sonnet-20250219-v1:0';

    case BEDROCK_CLAUDE_OPUS_4_5_20251101 = 'anthropic.claude-opus-4-5-20251101-v1:0';

    case BEDROCK_CLAUDE_OPUS_4_1_20250805 = 'anthropic.claude-opus-4-1-20250805-v1:0';

    case BEDROCK_CLAUDE_OPUS_4_20250514 = 'anthropic.claude-opus-4-20250514-v1:0';

    case BEDROCK_CLAUDE_HAIKU_4_5_20251001 = 'anthropic.claude-haiku-4-5-20251001-v1:0';

    /**
     * @deprecated Model is deprecated. Migrate to anthropic.claude-haiku-4-5-20251001-v1:0.
     */
    case BEDROCK_CLAUDE_3_5_HAIKU_20241022 = 'anthropic.claude-3-5-haiku-20241022-v1:0';

    case BEDROCK_CLAUDE_3_HAIKU_20240307 = 'anthropic.claude-3-haiku-20240307-v1:0';
    // Vertex AI model identifiers

    case VERTEX_CLAUDE_OPUS_4_5_20251101 = 'claude-opus-4-5@20251101';

    case VERTEX_CLAUDE_OPUS_4_1_20250805 = 'claude-opus-4-1@20250805';

    case VERTEX_CLAUDE_OPUS_4_20250514 = 'claude-opus-4@20250514';

    case VERTEX_CLAUDE_SONNET_4_5_20250929 = 'claude-sonnet-4-5@20250929';

    case VERTEX_CLAUDE_SONNET_4_20250514 = 'claude-sonnet-4@20250514';

    /**
     * @deprecated Model is deprecated. Migrate to claude-sonnet-4@20250514.
     */
    case VERTEX_CLAUDE_3_7_SONNET_20250219 = 'claude-3-7-sonnet@20250219';

    case VERTEX_CLAUDE_HAIKU_4_5_20251001 = 'claude-haiku-4-5@20251001';

    /**
     * @deprecated Model is deprecated. Migrate to claude-haiku-4-5@20251001.
     */
    case VERTEX_CLAUDE_3_5_HAIKU_20241022 = 'claude-3-5-haiku@20241022';

    case VERTEX_CLAUDE_3_HAIKU_20240307 = 'claude-3-haiku@20240307';
}
