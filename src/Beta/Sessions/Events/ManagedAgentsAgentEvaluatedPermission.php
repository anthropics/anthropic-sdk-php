<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

/**
 * AgentEvaluatedPermission enum.
 */
enum ManagedAgentsAgentEvaluatedPermission: string
{
    case ALLOW = 'allow';

    case ASK = 'ask';

    case DENY = 'deny';
}
