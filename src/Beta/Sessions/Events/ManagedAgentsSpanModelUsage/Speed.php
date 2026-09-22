<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelUsage;

/**
 * Inference speed tier this request actually ran at. Mirrors `usage.speed` on /v1/messages. Only present when the fast-mode beta is active.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
