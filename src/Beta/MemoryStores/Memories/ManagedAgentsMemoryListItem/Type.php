<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryListItem;

enum Type: string
{
    case MEMORY = 'memory';

    case MEMORY_PREFIX = 'memory_prefix';
}
