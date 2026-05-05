<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadCreatedEvent;

enum Type: string
{
    case SESSION_THREAD_CREATED = 'session.thread_created';
}
