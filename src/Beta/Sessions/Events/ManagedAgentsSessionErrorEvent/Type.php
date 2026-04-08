<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;

enum Type: string
{
    case SESSION_ERROR = 'session.error';
}
