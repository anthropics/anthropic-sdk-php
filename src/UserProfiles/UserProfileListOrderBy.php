<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * Sort field for listing user profiles: `created_at` (default) or `name` (case-insensitive; profiles without a name sort last).
 */
enum UserProfileListOrderBy: string
{
    /**
     * Sort by when each user profile was created. This is the default.
     */
    case CREATED_AT = 'created_at';

    /**
     * Sort by `name`, ignoring the case of ASCII letters. Profiles without a name come last in either direction.
     */
    case NAME = 'name';
}
