<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

/**
 * MemoryVersionOperation enum.
 */
enum ManagedAgentsMemoryVersionOperation: string
{
    case CREATED = 'created';

    case MODIFIED = 'modified';

    case DELETED = 'deleted';
}
