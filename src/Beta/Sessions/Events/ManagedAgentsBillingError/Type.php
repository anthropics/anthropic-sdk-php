<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError;

enum Type: string
{
    case BILLING_ERROR = 'billing_error';
}
