<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsActor;

enum Type: string
{
    case USER_ACTOR = 'user_actor';

    case SERVICE_ACCOUNT_ACTOR = 'service_account_actor';

    case FEDERATED_ACTOR = 'federated_actor';

    case API_ACTOR = 'api_actor';
}
