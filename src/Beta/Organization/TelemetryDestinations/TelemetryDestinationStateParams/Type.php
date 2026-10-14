<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
