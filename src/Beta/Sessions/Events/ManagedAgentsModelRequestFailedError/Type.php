<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError;

enum Type: string
{
    case MODEL_REQUEST_FAILED_ERROR = 'model_request_failed_error';
}
