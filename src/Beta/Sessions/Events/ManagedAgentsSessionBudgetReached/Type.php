<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionBudgetReached;

enum Type: string
{
    case BUDGET_REACHED = 'budget_reached';
}
