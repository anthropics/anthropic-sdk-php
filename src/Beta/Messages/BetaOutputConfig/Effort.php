<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaOutputConfig;

/**
 * All possible effort levels.
 */
enum Effort: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';
}
