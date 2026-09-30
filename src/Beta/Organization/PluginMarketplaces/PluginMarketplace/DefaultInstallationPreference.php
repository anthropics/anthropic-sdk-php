<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;

/**
 * Organization plugin marketplace: the organization-wide setting every Plugin in it with no setting of its own gets. Null for a member's personal plugin marketplace. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
 */
enum DefaultInstallationPreference: string
{
    case AUTO_INSTALL = 'auto_install';

    case AVAILABLE = 'available';

    case NOT_AVAILABLE = 'not_available';

    case REQUIRED = 'required';
}
