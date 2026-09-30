<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRefusalStopDetails;

/**
 * The policy category that triggered the refusal, or `null` when there is no named category. New values can be added over time.
 */
enum Category: string
{
    case CYBER = 'cyber';

    case BIO = 'bio';

    case FRONTIER_LLM = 'frontier_llm';

    case REASONING_EXTRACTION = 'reasoning_extraction';

    case GENERAL_HARMS = 'general_harms';
}
