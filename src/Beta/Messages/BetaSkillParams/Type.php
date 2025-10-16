<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaSkillParams;

/**
 * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
 */
enum Type: string
{
    case ANTHROPIC = 'anthropic';

    case CUSTOM = 'custom';
}
