<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaOutputConfig;

/**
 * How much effort the model should put into its response. Higher effort levels may result in more thorough analysis but take longer.
 *
 * Valid values are `low`, `medium`, or `high`.
 */
enum Effort: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';
}
