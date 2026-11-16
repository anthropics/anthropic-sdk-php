<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\RBACRoleSource;

enum Type: string
{
    case BUILT_IN = 'built_in';

    case CUSTOM = 'custom';
}
