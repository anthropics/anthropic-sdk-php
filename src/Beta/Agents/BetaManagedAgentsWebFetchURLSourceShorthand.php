<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

/**
 * String form of a url_sources value that has no field other than its type: "all" means {"type": "all"} and "none" means {"type": "none"}.
 */
enum BetaManagedAgentsWebFetchURLSourceShorthand: string
{
    case ALL = 'all';

    case NONE = 'none';
}
