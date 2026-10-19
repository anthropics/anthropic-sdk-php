<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

/**
 * Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
 *
 * With `full`, list operations return at most 20 items per page.
 */
enum ManagedAgentsMemoryView: string
{
    /**
     * Return the object with `content` set to `null`. The `content_size_bytes` and `content_sha256` fields remain populated, so sync clients can diff without fetching content.
     */
    case BASIC = 'basic';

    /**
     * Return the object with `content` populated. On list endpoints, `view=full` caps `limit` at 20.
     */
    case FULL = 'full';
}
