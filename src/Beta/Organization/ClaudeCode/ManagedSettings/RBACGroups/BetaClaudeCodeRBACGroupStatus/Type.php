<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatus;

enum Type: string
{
    case ACTIVE = 'active';

    case DELETED = 'deleted';

    case UNKNOWN = 'unknown';
}
