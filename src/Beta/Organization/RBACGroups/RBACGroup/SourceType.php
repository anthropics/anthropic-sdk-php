<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups\RBACGroup;

/**
 * How the RBAC Group was created: `"direct"` for groups created directly (for example, in the organization's admin settings), `"scim"` for groups provisioned by the identity provider.
 */
enum SourceType: string
{
    case DIRECT = 'direct';

    case SCIM = 'scim';
}
