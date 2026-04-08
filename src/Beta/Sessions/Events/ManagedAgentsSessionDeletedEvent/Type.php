<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent;

enum Type: string
{
    case SESSION_DELETED = 'session.deleted';
}
