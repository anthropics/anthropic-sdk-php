<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationStartEvent;

enum Type: string
{
    case SPAN_OUTCOME_EVALUATION_START = 'span.outcome_evaluation_start';
}
