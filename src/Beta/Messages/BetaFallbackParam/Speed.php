<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackParam;

enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
