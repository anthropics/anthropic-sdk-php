<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * The next step on this enforcement action: `verify` means the end user can clear the action by passing an identity check. More values may be added; read a value you do not recognize as `null`.
 */
enum UserProfileEnforcementActionNextStep: string
{
    case VERIFY = 'verify';
}
