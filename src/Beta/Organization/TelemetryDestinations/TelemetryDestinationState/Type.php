<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationState;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
