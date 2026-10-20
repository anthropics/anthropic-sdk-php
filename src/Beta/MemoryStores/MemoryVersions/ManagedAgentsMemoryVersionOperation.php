<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

/**
 * The kind of change that a memory version records.
 *
 * Every change to a memory adds one version. If you update a memory and nothing changes, the memory doesn't get a new version.
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
