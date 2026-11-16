<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsBillingErrorObject\RetryStatus;

enum Type: string
{
    case RETRYING = 'retrying';

    case EXHAUSTED = 'exhausted';

    case TERMINAL = 'terminal';
}

class_alias(
    Type::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError\RetryStatus\Type',
);
