<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams;

/**
 * Inference speed mode. Defaults to `standard`.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
