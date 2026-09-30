<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope;

enum Type: string
{
    case USER = 'user';

    case ORGANIZATION = 'organization';

    case WORKSPACE = 'workspace';
}
