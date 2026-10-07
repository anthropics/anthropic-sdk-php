<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendSummary\Source;

enum Type: string
{
    case USER = 'user';

    case SEAT_TIER = 'seat_tier';

    case RBAC_GROUP = 'rbac_group';

    case ORGANIZATION_SERVICE = 'organization_service';

    case ORGANIZATION = 'organization';

    case WORKSPACE = 'workspace';
}
