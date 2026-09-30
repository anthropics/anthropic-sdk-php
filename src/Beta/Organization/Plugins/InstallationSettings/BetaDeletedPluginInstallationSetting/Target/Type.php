<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting\Target;

enum Type: string
{
    case ORGANIZATION = 'organization';

    case RBAC_GROUP = 'rbac_group';

    case ORGANIZATION_MEMBER = 'organization_member';
}
