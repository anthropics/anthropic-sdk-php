<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsAgent\Skill;

enum Type: string
{
    case ANTHROPIC = 'anthropic';

    case CUSTOM = 'custom';
}
