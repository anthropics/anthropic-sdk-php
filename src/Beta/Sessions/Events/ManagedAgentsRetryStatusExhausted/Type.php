<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusExhausted;

enum Type: string
{
    case EXHAUSTED = 'exhausted';
}
