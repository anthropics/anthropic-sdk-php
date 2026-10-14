<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsExecutionIdentityParams;

enum Type: string
{
    case AWS_ROLE = 'aws_role';

    case SERVICE_ACCOUNT = 'service_account';
}
