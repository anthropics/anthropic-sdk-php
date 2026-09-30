<?php

declare(strict_types=1);

namespace Anthropic\Organization\APIKeys\APIKey;

/**
 * Status of the API key.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case ARCHIVED = 'archived';

    case EXPIRED = 'expired';

    case INACTIVE = 'inactive';
}
