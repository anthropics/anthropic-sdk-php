<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendLimitListParams;

enum ScopeType: string
{
    case OAUTH_APP = 'oauth_app';

    case OAUTH_APP_DEFAULT = 'oauth_app_default';

    case ORGANIZATION = 'organization';

    case ORGANIZATION_SERVICE = 'organization_service';

    case RBAC_GROUP = 'rbac_group';

    case SEAT_TIER = 'seat_tier';

    case USER = 'user';

    case WORKSPACE = 'workspace';
}
