<?php

declare(strict_types=1);

namespace Anthropic\Organization\Analytics;

/**
 * A dimension to group chat project activity by.
 */
enum AnalyticsProjectGroupBy: string
{
    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
