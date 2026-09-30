<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingSetParams;

/**
 * The installation setting the target is to hold for this Plugin: one of `required`, `auto_install`, `available`, `not_available`.
 */
enum InstallationPreference: string
{
    case AUTO_INSTALL = 'auto_install';

    case AVAILABLE = 'available';

    case NOT_AVAILABLE = 'not_available';

    case REQUIRED = 'required';
}
