<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

/**
 * Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
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
