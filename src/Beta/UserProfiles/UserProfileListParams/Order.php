<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileListParams;

/**
 * ListOrder enum.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
