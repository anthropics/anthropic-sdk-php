<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles\UserProfileEfsFeature;

/**
 * `active` when Anthropic has approved the entity the profile represents to use the feature, otherwise `inactive`. `active` does not mean that the feature is set up or switched on, which is a separate step.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
