<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentWorkflows;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
