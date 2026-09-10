<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

/**
 * The model that will power your agent.
 *
 * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
 */
enum BetaManagedAgentsModel: string
{
    /**
     * Frontier intelligence for ambitious tasks across coding, scientific discovery, and enterprise workflows.
     */
    case CLAUDE_FABLE_5_1 = 'claude-fable-5-1';

    /**
     * High-performance model for coding and agents.
     */
    case CLAUDE_SONNET_5 = 'claude-sonnet-5';

    /**
     * Next generation of intelligence for the hardest knowledge work and coding problems.
     */
    case CLAUDE_FABLE_5 = 'claude-fable-5';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_5 = 'claude-opus-5';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_4_8 = 'claude-opus-4-8';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_4_7 = 'claude-opus-4-7';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_4_6 = 'claude-opus-4-6';

    /**
     * Best combination of speed and intelligence.
     */
    case CLAUDE_SONNET_4_6 = 'claude-sonnet-4-6';

    /**
     * Fastest model with near-frontier intelligence.
     */
    case CLAUDE_HAIKU_4_5 = 'claude-haiku-4-5';

    /**
     * Fastest model with near-frontier intelligence.
     */
    case CLAUDE_HAIKU_4_5_20251001 = 'claude-haiku-4-5-20251001';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_4_5 = 'claude-opus-4-5';

    /**
     * Powerful intelligence for long-running agents and coding.
     */
    case CLAUDE_OPUS_4_5_20251101 = 'claude-opus-4-5-20251101';

    /**
     * High-performance model for agents and coding.
     */
    case CLAUDE_SONNET_4_5 = 'claude-sonnet-4-5';

    /**
     * High-performance model for agents and coding.
     */
    case CLAUDE_SONNET_4_5_20250929 = 'claude-sonnet-4-5-20250929';
}
