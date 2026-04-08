<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;

enum Type: string
{
    case AGENT_MESSAGE = 'agent.message';
}
