<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles\UserProfileEnforcementAction;

enum Type: string
{
    case RESTRICTION = 'restriction';

    case BAN = 'ban';
}
