<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent;

/**
 * AgentEvaluatedPermission enum.
 */
enum EvaluatedPermission: string
{
    case ALLOW = 'allow';

    case ASK = 'ask';

    case DENY = 'deny';
}
