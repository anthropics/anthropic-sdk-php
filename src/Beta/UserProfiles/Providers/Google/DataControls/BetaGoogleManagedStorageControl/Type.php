<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControl;

enum Type: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
