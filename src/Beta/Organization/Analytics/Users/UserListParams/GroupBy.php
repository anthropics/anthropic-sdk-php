<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Users\UserListParams;

enum GroupBy: string
{
    case RBAC_GROUP_ID = 'rbac_group_id';
}
