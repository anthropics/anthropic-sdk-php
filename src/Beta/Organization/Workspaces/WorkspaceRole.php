<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

enum WorkspaceRole: string
{
    case WORKSPACE_ADMIN = 'workspace_admin';

    case WORKSPACE_BILLING = 'workspace_billing';

    case WORKSPACE_DEVELOPER = 'workspace_developer';

    case WORKSPACE_RESTRICTED_DEVELOPER = 'workspace_restricted_developer';

    case WORKSPACE_USER = 'workspace_user';
}
