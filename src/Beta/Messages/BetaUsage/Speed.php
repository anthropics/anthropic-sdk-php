<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaUsage;

/**
 * The inference speed mode used for this request.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
