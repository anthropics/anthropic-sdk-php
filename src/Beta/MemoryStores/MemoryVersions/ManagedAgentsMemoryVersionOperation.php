<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

/**
 * The kind of mutation a `memory_version` records. Every non-no-op mutation to a memory appends exactly one version row with one of these values.
 */
enum ManagedAgentsMemoryVersionOperation: string
{
    case CREATED = 'created';

    case MODIFIED = 'modified';

    case DELETED = 'deleted';
}
