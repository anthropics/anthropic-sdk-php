<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin;

/**
 * Organization-owned Plugin: the organization-wide installation setting every member gets unless an RBAC Group they belong to holds its own — the Plugin's own setting, or its plugin marketplace's default. Null for a member-owned Plugin, which has shares instead. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
 */
enum OrganizationInstallationPreference: string
{
    case AUTO_INSTALL = 'auto_install';

    case AVAILABLE = 'available';

    case NOT_AVAILABLE = 'not_available';

    case REQUIRED = 'required';
}
