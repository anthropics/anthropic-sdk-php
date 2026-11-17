<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

/**
 * Who is billed for a request.
 */
enum BetaBillTo: string
{
    case SELF = 'self';

    case USER_PROFILE = 'user_profile';
}
