<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfile;

/**
 * How the platform uses the API for this entity: `application` (default) or `passthrough`. Present under the `user-profiles-2026-08-18` and later beta headers.
 */
enum AccessType: string
{
    /**
     * The user profile represents an individual end-user of a product that the platform builds on the API. New profiles get this value by default.
     */
    case APPLICATION = 'application';

    /**
     * The user profile represents a company that the platform resells Claude access to.
     */
    case PASSTHROUGH = 'passthrough';
}
