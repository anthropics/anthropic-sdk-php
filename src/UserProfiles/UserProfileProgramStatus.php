<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * A user profile's status in a program. Each program's `status` field says what the values mean there.
 */
enum UserProfileProgramStatus: string
{
    /**
     * The profile is in the program.
     */
    case ACTIVE = 'active';

    /**
     * The profile is not in the program yet, and something is still awaited.
     */
    case PENDING = 'pending';

    /**
     * The profile is not in the program and nothing is awaited: Anthropic has declined, or has withdrawn an earlier approval.
     */
    case REJECTED = 'rejected';
}
