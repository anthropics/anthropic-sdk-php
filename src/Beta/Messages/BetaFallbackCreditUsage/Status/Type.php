<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackCreditUsage\Status;

enum Type: string
{
    case REDEEMED = 'redeemed';

    case NOT_APPLIED = 'not_applied';
}
