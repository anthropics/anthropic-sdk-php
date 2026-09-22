<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\UserProfileUpdateParams;

/**
 * If present, replaces the stored access type. Omit to leave unchanged.
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
