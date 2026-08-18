<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusIdleEvent\StopReason;

enum Type: string
{
    case END_TURN = 'end_turn';

    case REQUIRES_ACTION = 'requires_action';

    case RETRIES_EXHAUSTED = 'retries_exhausted';

    case BUDGET_REACHED = 'budget_reached';
}
