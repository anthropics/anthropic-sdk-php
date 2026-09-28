<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileCreateParams;

/**
 * How the platform uses the API for this entity. `application` (default): the profile represents an individual end-user of the platform's product. `passthrough`: the profile identifies a company the platform resells Claude access to.
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
