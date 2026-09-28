<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting;

/**
 * The setting the target holds for this Plugin. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
 */
enum InstallationPreference: string
{
    case AUTO_INSTALL = 'auto_install';

    case AVAILABLE = 'available';

    case NOT_AVAILABLE = 'not_available';

    case REQUIRED = 'required';
}
