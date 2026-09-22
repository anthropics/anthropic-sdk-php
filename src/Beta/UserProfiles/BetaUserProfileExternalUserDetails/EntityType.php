<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails;

/**
 * What kind of entity the profile represents: `individual`, `business`, `non_profit` or `government`. `null` until the platform supplies one.
 */
enum EntityType: string
{
    case INDIVIDUAL = 'individual';

    case BUSINESS = 'business';

    case NON_PROFIT = 'non_profit';

    case GOVERNMENT = 'government';
}
