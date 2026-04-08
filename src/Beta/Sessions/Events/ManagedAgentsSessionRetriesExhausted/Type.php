<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRetriesExhausted;

enum Type: string
{
    case RETRIES_EXHAUSTED = 'retries_exhausted';
}
