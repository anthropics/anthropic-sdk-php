<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
 */
enum OrderBy: string
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
