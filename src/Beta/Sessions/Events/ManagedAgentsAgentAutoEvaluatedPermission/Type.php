<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermission;

enum Type: string
{
    case ALLOW = 'allow';

    case ASK = 'ask';

    case DENY = 'deny';
}
