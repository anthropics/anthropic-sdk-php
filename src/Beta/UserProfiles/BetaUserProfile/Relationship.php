<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfile;

/**
 * How the entity behind a user profile relates to the platform that owns the API key. `external`: an individual end-user of the platform. `resold`: a company the platform resells Claude access to. `internal`: the platform's own usage.
 */
enum Relationship: string
{
    case EXTERNAL = 'external';

    case RESOLD = 'resold';

    case INTERNAL = 'internal';
}
