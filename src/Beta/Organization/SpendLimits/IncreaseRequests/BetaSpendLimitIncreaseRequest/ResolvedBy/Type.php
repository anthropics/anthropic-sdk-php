<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest\ResolvedBy;

enum Type: string
{
    case USER_ACTOR = 'user_actor';

    case SCOPED_API_KEY_ACTOR = 'scoped_api_key_actor';
}
