<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError;

enum Type: string
{
    case MODEL_OVERLOADED_ERROR = 'model_overloaded_error';
}
