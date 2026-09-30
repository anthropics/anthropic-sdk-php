<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Skills\SkillListParams;

enum GroupBy: string
{
    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case USER_ID = 'user_id';
}
