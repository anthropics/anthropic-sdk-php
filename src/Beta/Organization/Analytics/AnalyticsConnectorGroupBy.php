<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

/**
 * A dimension to group connector activity by.
 */
enum AnalyticsConnectorGroupBy: string
{
    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
