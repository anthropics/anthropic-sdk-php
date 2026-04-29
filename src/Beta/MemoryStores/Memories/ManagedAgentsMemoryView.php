<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

/**
 * Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
 */
enum ManagedAgentsMemoryView: string
{
    case BASIC = 'basic';

    case FULL = 'full';
}
