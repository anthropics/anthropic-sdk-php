<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACRoles\Permissions\RBACRolePermission\Resource;

enum Type: string
{
    case ORGANIZATION = 'organization';

    case CONNECTOR_TOOL = 'connector_tool';

    case CONNECTOR_SCOPE = 'connector_scope';

    case CONNECTOR = 'connector';

    case ALL_CONNECTORS = 'all_connectors';
}
