<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfile;

/**
 * Object type. Always `user_profile`.
 */
enum Type: string
{
    case USER_PROFILE = 'user_profile';
}
