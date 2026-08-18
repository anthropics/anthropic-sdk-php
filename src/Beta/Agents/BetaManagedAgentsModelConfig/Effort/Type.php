<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Effort;

enum Type: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    case XHIGH = 'xhigh';

    case MAX = 'max';
}
