<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfile;

/**
 * How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
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
