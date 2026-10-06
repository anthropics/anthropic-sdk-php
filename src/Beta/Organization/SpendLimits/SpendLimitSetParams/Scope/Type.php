<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope;

enum Type: string
{
    case USER = 'user';

    case ORGANIZATION = 'organization';

    case WORKSPACE = 'workspace';

    case OAUTH_APP = 'oauth_app';

    case OAUTH_APP_DEFAULT = 'oauth_app_default';
}
