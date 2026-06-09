<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent;

enum Type: string
{
    case USER_MESSAGE = 'user.message';
}
