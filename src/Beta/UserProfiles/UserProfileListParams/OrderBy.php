<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * Sort field for listing user profiles: `created_at` (default) or `name` (case-insensitive; profiles without a name sort last).
 */
enum OrderBy: string
{
    case CREATED_AT = 'created_at';

    case NAME = 'name';
}
