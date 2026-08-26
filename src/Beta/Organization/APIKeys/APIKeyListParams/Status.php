<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys\APIKeyListParams;

/**
 * Filter by API key status.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case ARCHIVED = 'archived';

    case EXPIRED = 'expired';

    case INACTIVE = 'inactive';
}
