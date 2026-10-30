<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

/**
 * A dimension to group skill activity by.
 */
enum AnalyticsSkillGroupBy: string
{
    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
