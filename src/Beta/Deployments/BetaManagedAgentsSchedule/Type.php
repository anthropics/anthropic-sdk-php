<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsSchedule;

enum Type: string
{
    case CRON = 'cron';
}
