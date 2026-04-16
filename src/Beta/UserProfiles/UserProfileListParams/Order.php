<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * Query parameter for order.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
