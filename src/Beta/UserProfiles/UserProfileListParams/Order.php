<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
 */
enum Order: string
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
