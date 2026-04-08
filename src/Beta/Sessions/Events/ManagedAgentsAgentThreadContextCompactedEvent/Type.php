<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent;

enum Type: string
{
    case AGENT_THREAD_CONTEXT_COMPACTED = 'agent.thread_context_compacted';
}
