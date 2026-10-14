<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDisabledReason;

enum Type: string
{
    case CALLER = 'caller';

    case SUSTAINED_FAILURE = 'sustained_failure';

    case INVALID_ADDRESS = 'invalid_address';

    case REDIRECT = 'redirect';
}
