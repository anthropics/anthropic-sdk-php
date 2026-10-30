<?php

declare(strict_types=1);

namespace Anthropic\Organization\Analytics;

/**
 * A dimension to group plugin activity by.
 */
enum AnalyticsPluginGroupBy: string
{
    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
