<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories\ManagedAgentsConflictError;

enum Type: string
{
    case CONFLICT_ERROR = 'conflict_error';
}
