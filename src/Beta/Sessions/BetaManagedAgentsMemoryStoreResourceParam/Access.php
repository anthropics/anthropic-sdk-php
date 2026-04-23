<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsMemoryStoreResourceParam;

/**
 * Access mode for an attached memory store.
 */
enum Access: string
{
    case READ_WRITE = 'read_write';

    case READ_ONLY = 'read_only';
}
