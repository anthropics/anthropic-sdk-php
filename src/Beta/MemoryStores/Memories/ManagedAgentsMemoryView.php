<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

/**
 * MemoryView enum.
 */
enum ManagedAgentsMemoryView: string
{
    case BASIC = 'basic';

    case FULL = 'full';
}
