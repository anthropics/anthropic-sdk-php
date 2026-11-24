<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControl;

enum Type: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
