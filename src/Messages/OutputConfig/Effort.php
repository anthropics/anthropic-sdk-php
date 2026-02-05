<?php

declare(strict_types=1);

namespace Anthropic\Messages\OutputConfig;

/**
 * All possible effort levels.
 */
enum Effort: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    case MAX = 'max';
}
