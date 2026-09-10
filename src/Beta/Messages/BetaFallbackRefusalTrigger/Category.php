<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackRefusalTrigger;

/**
 * The policy category that triggered a refusal.
 */
enum Category: string
{
    /**
     * The request could enable cyber harm, such as malware or exploit development. Benign cybersecurity work can also trigger this category.
     */
    case CYBER = 'cyber';

    /**
     * The request could enable biological harm, such as dangerous lab methods. Beneficial life sciences work can also trigger this category.
     */
    case BIO = 'bio';

    /**
     * The request could assist the development of competing AI models, which is restricted under [Anthropic's commercial terms](https://www.anthropic.com/legal/commercial-terms). Benign machine learning work can also trigger this category.
     */
    case FRONTIER_LLM = 'frontier_llm';

    /**
     * The request asks the model to reproduce its internal reasoning in the response text. To get reasoning in a structured form instead, use [adaptive thinking](https://platform.claude.com/docs/en/build-with-claude/adaptive-thinking).
     */
    case REASONING_EXTRACTION = 'reasoning_extraction';

    /**
     * The request could be related to an area that was determined as harmful. Benign work might sometimes trigger this category.
     */
    case GENERAL_HARMS = 'general_harms';
}
