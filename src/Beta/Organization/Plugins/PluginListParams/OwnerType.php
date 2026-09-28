<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\PluginListParams;

/**
 * `organization` for Plugins in the organization's plugin marketplaces, `user` for Plugins in members' personal plugin marketplaces.
 */
enum OwnerType: string
{
    case ORGANIZATION = 'organization';

    case USER = 'user';
}
