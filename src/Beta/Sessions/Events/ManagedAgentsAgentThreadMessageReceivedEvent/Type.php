<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent;

enum Type: string
{
    case AGENT_THREAD_MESSAGE_RECEIVED = 'agent.thread_message_received';
}
