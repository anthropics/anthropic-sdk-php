<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\EventListParams;

/**
 * Sort direction for results, ordered by the event's `processed_at`. Defaults to asc (chronological).
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
