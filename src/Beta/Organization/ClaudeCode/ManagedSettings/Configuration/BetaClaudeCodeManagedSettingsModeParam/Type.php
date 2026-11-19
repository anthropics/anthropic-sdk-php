<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam;

enum Type: string
{
    case ORGANIZATION = 'organization';

    case RBAC_GROUPS = 'rbac_groups';
}
