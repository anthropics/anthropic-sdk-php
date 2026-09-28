<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Shares\ShareListParams;

/**
 * Only shares with this kind of target: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member).
 */
enum TargetType: string
{
    case ORGANIZATION = 'organization';

    case ORGANIZATION_MEMBER = 'organization_member';

    case RBAC_GROUP = 'rbac_group';
}
