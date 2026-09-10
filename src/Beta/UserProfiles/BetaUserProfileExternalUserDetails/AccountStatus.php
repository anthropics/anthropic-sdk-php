<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetails;

/**
 * The status of the entity's account on the platform, as the platform states it: `active`; `suspended`, when the platform has restricted the account and may restore it; or `blocked`, when the platform has barred it. It records the platform's decision only; the statuses in `trust_grants` are Anthropic's and do not follow it.
 */
enum AccountStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';

    case BLOCKED = 'blocked';
}
