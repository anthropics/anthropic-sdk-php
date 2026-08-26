<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount;

/**
 * Org-level role. A federation rule may only be created or retargeted to grant `org:admin` scope when this is `admin`. A rule granting `org:admin` whose target is later demoted to `developer` is rejected at token exchange. Rules granting `org:admin` are managed in the Console.
 */
enum OrganizationRole: string
{
    case ADMIN = 'admin';

    case DEVELOPER = 'developer';
}
