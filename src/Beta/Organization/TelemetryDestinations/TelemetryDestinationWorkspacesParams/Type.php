<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams;

enum Type: string
{
    case ALL = 'all';

    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';
}
