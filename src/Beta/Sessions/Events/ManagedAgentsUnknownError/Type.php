<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError;

enum Type: string
{
    case UNKNOWN_ERROR = 'unknown_error';
}
