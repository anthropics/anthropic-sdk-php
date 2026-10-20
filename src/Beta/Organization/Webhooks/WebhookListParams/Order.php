<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks\WebhookListParams;

/**
 * Sort order by `created_at`. Defaults to `desc`, newest first.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
