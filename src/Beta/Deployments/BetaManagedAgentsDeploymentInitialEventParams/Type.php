<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams;

enum Type: string
{
    case USER_MESSAGE = 'user.message';

    case USER_DEFINE_OUTCOME = 'user.define_outcome';

    case SYSTEM_MESSAGE = 'system.message';
}
