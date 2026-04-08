<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent;

enum Type: string
{
    case SPAN_MODEL_REQUEST_END = 'span.model_request_end';
}
