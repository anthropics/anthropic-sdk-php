<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

/**
 * The kind of mutation a `memory_version` records. Every non-no-op mutation to a memory appends exactly one version row with one of these values.
 */
enum ManagedAgentsMemoryVersionOperation: string
{
    /**
     * The memory was created. The first version in any memory's lineage.
     */
    case CREATED = 'created';

    /**
     * The memory's `content`, `path`, or both were changed via update. Writes the agent makes through the filesystem mount also appear as `modified`.
     */
    case MODIFIED = 'modified';

    /**
     * The memory was deleted. The `content`, `content_size_bytes`, and `content_sha256` fields are `null` on this version. The preceding version, while it is retained, records the deleted content's size and hash.
     */
    case DELETED = 'deleted';
}
