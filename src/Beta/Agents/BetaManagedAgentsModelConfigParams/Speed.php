<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams;

/**
 * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
