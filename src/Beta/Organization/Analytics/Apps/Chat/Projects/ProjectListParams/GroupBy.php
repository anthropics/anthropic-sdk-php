<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Apps\Chat\Projects\ProjectListParams;

enum GroupBy: string
{
    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
