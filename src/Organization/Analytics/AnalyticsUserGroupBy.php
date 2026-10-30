<?php

declare(strict_types=1);

namespace Anthropic\Organization\Analytics;

/**
 * A dimension to group user activity by.
 */
enum AnalyticsUserGroupBy: string
{
    case RBAC_GROUP_ID = 'rbac_group_id';
}
