<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys\APIKeyCreatedBy;

/**
 * Type of the actor that created the object.
 */
enum Type: string
{
    case SERVICE_ACCOUNT = 'service_account';

    case USER = 'user';
}
