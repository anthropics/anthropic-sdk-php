<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentSystemMessageEvent;

enum Type: string
{
    case SYSTEM_MESSAGE = 'system.message';
}
