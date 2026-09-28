<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreResourceConfig;

/**
 * Access mode for the mounted store. Defaults to `read_write`. `read_only` mounts the store as a read-only filesystem.
 */
enum Access: string
{
    case READ_WRITE = 'read_write';

    case READ_ONLY = 'read_only';
}
