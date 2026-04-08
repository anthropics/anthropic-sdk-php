<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThinkingEvent;

enum Type: string
{
    case AGENT_THINKING = 'agent.thinking';
}
