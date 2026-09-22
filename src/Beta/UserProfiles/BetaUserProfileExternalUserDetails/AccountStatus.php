<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails;

/**
 * The status of the entity's account on the platform: `active`, `suspended` or `blocked`. `null` until the platform supplies one.
 */
enum AccountStatus: string
{
    /**
     * The platform has neither restricted nor barred the account of the entity that the user profile represents.
     */
    case ACTIVE = 'active';

    /**
     * The platform has restricted the account of the entity that the user profile represents and may restore it.
     */
    case SUSPENDED = 'suspended';

    /**
     * The platform has barred the account of the entity that the user profile represents.
     */
    case BLOCKED = 'blocked';
}
