<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams;

/**
 * Org-level role. Defaults to `developer`.
 */
enum OrganizationRole: string
{
    case ADMIN = 'admin';

    case DEVELOPER = 'developer';
}
