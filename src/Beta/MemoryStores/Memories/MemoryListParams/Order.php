<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories\MemoryListParams;

/**
 * Query parameter for order.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
