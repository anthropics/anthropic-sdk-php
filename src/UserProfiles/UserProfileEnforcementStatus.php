<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * Anthropic's enforcement status of this profile: `unrestricted`, `pending`, `restricted` or `banned`. More values may be added; read a value you do not recognize as `restricted`.
 */
enum UserProfileEnforcementStatus: string
{
    case UNRESTRICTED = 'unrestricted';

    case PENDING = 'pending';

    case RESTRICTED = 'restricted';

    case BANNED = 'banned';
}
