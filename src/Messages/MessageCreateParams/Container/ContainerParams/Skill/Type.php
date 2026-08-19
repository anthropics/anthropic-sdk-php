<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageCreateParams\Container\ContainerParams\Skill;

/**
 * Type of skill - either 'anthropic' (built-in) or 'custom' (user-defined).
 */
enum Type: string
{
    case ANTHROPIC = 'anthropic';

    case CUSTOM = 'custom';
}
