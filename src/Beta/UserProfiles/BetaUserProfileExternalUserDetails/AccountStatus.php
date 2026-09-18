<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails;

/**
 * The status of the entity's account on the platform, as the platform states it: `active`; `suspended`, when the platform has restricted the account and may restore it; or `blocked`, when the platform has barred it. It records the platform's decision only; the statuses in `trust_grants` are Anthropic's and do not follow it.
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
