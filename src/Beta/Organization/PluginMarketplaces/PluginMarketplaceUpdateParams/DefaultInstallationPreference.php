<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams;

/**
 * The organization-wide installation setting every Plugin in the marketplace without one of its own gets: one of `required`, `auto_install`, `available`, `not_available`. Once set it can be changed but not removed.
 */
enum DefaultInstallationPreference: string
{
    case AUTO_INSTALL = 'auto_install';

    case AVAILABLE = 'available';

    case NOT_AVAILABLE = 'not_available';

    case REQUIRED = 'required';
}
