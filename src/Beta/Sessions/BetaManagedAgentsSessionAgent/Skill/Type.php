<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent\Skill;

enum Type: string
{
    case ANTHROPIC = 'anthropic';

    case CUSTOM = 'custom';
}
