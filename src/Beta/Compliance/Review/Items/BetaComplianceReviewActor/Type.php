<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewActor;

enum Type: string
{
    case USER_ACTOR = 'user_actor';

    case API_ACTOR = 'api_actor';

    case SERVICE_ACCOUNT_ACTOR = 'service_account_actor';
}
