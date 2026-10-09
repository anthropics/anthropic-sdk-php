<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentSubagents;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
