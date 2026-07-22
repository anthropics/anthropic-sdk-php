<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams\Effort;

/**
 * How hard Claude works on each turn. Higher levels favor reasoning depth over latency. Not all models accept every level; invalid combinations are rejected at create time.
 */
enum BetaManagedAgentsEffortLevel: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    case XHIGH = 'xhigh';

    case MAX = 'max';
}
