<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams;

enum Type: string
{
    case CRON = 'cron';
}
