<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;

/**
 * Object type. Always `enrollment_url`.
 */
enum Type: string
{
    case ENROLLMENT_URL = 'enrollment_url';
}
