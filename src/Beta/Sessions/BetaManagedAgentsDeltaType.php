<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

/**
 * EventDeltaType enum.
 */
enum BetaManagedAgentsDeltaType: string
{
    case AGENT_MESSAGE = 'agent.message';

    case AGENT_THINKING = 'agent.thinking';
}
