<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionStatus;

enum Type: string
{
    case NOT_CONFIGURED = 'not_configured';

    case PENDING = 'pending';

    case ACTIVE = 'active';

    case FAILED = 'failed';

    case SUSPENDED = 'suspended';
}
