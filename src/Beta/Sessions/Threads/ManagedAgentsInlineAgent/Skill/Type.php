<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent\Skill;

enum Type: string
{
    case ANTHROPIC = 'anthropic';

    case CUSTOM = 'custom';
}
