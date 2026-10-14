<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResult;

enum Type: string
{
    case SUCCESS = 'success';

    case FAILURE = 'failure';
}
