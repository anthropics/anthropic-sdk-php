<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilter;

enum Type: string
{
    case ALL = 'all';

    case NONE = 'none';

    case ONLY = 'only';

    case EXCEPT = 'except';
}
