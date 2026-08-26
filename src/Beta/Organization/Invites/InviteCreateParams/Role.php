<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Invites\InviteCreateParams;

/**
 * Role for the invited User.
 *
 * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`.
 */
enum Role: string
{
    case BILLING = 'billing';

    case CLAUDE_CODE_USER = 'claude_code_user';

    case DEVELOPER = 'developer';

    case MANAGED = 'managed';

    case USER = 'user';
}
