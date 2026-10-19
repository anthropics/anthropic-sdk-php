<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * What kind of entity the profile represents, as the platform states it: `individual`, `business`, `non_profit` or `government`.
 */
enum UserProfileExternalUserEntityType: string
{
    case INDIVIDUAL = 'individual';

    case BUSINESS = 'business';

    case NON_PROFIT = 'non_profit';

    case GOVERNMENT = 'government';
}
