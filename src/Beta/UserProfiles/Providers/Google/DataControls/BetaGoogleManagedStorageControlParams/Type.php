<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams;

enum Type: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
