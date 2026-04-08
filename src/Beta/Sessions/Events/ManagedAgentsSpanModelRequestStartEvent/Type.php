<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent;

enum Type: string
{
    case SPAN_MODEL_REQUEST_START = 'span.model_request_start';
}
