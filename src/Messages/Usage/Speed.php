<?php

declare(strict_types=1);

namespace Anthropic\Messages\Usage;

/**
 * The inference speed mode used for this request.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
