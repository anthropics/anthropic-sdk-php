<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

enum BetaOrganizationRole: string
{
    case ADMIN = 'admin';

    case BILLING = 'billing';

    case CLAUDE_CODE_USER = 'claude_code_user';

    case DEVELOPER = 'developer';

    case MANAGED = 'managed';

    case MEMBERSHIP_ADMIN = 'membership_admin';

    case OWNER = 'owner';

    case PRIMARY_OWNER = 'primary_owner';

    case USER = 'user';
}
