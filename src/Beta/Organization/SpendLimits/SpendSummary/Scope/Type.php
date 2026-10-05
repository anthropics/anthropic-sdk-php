<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendSummary\Scope;

enum Type: string
{
    case USER = 'user';

    case SEAT_TIER = 'seat_tier';

    case RBAC_GROUP = 'rbac_group';

    case ORGANIZATION_SERVICE = 'organization_service';

    case ORGANIZATION = 'organization';

    case WORKSPACE = 'workspace';

    case OAUTH_APP = 'oauth_app';

    case OAUTH_APP_DEFAULT = 'oauth_app_default';
}
