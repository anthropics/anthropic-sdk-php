<?php

declare(strict_types=1);

namespace Anthropic\Messages\RefusalStopDetails;

/**
 * The policy category that triggered a refusal.
 */
enum Category: string
{
    case CYBER = 'cyber';

    case BIO = 'bio';

    case FRONTIER_LLM = 'frontier_llm';

    case REASONING_EXTRACTION = 'reasoning_extraction';
}
