<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * The direction that a list of user profiles is sorted in.
 */
enum UserProfileListOrder: string
{
    /**
     * Oldest first when `order_by` is `created_at`, or names in ascending order when `order_by` is `name`.
     */
    case ASC = 'asc';

    /**
     * Newest first when `order_by` is `created_at`, or names in descending order when `order_by` is `name`. This is the default.
     */
    case DESC = 'desc';
}
