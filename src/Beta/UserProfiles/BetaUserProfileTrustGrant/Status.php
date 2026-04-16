<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileTrustGrant;

/**
 * Status of the trust grant.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case PENDING = 'pending';

    case REJECTED = 'rejected';
}
