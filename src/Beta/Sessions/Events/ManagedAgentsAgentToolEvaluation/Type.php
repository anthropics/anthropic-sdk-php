<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluation;

enum Type: string
{
    case ALWAYS_ALLOW = 'always_allow';

    case ALWAYS_ASK = 'always_ask';

    case AUTO = 'auto';
}
