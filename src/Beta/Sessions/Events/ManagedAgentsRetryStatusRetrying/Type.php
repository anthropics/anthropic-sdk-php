<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusRetrying;

enum Type: string
{
    case RETRYING = 'retrying';
}
