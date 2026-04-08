<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionListParams;

/**
 * Sort direction for results, ordered by created_at. Defaults to desc (newest first).
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
