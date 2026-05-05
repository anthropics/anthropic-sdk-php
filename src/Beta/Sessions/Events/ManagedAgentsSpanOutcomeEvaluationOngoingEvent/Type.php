<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationOngoingEvent;

enum Type: string
{
    case SPAN_OUTCOME_EVALUATION_ONGOING = 'span.outcome_evaluation_ongoing';
}
