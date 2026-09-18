<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams\Effort;

/**
 * How hard Claude works on each turn. Higher levels favor reasoning depth over latency. Not all models accept every level; invalid combinations are rejected at create time.
 */
enum BetaManagedAgentsEffortLevel: string
{
    /**
     * Low effort. Favors latency over reasoning depth.
     */
    case LOW = 'low';

    /**
     * Medium effort. Balances latency and reasoning depth.
     */
    case MEDIUM = 'medium';

    /**
     * High effort. Favors reasoning depth.
     */
    case HIGH = 'high';

    /**
     * Extra-high effort. Not all models accept this level.
     */
    case XHIGH = 'xhigh';

    /**
     * Maximum effort. Favors reasoning depth over latency.
     */
    case MAX = 'max';
}
