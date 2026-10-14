<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageCreateParams;

/**
 * The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
