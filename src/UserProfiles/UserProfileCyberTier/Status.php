<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles\UserProfileCyberTier;

/**
 * `active` when the tier applies to the profile, otherwise `inactive`. The response does not say why a tier is `inactive`: it can be in review, declined, withdrawn, never applied for, or approved but not applied to this profile.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
