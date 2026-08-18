<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsStartEventPreview;

enum Type: string
{
    case AGENT_MESSAGE = 'agent.message';

    case AGENT_THINKING = 'agent.thinking';
}
