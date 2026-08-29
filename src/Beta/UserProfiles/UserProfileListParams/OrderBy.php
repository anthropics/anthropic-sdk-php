<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * Query parameter for order_by.
 */
enum OrderBy: string
{
    case CREATED_AT = 'created_at';

    case NAME = 'name';
}
