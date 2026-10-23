<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

/**
 * Kind of identity a row's usage is attributed to.
 */
enum AnalyticsActorType: string
{
    case API_ACTOR = 'api_actor';

    case FEDERATED_ACTOR = 'federated_actor';

    case SERVICE_ACCOUNT_ACTOR = 'service_account_actor';

    case USER_ACTOR = 'user_actor';
}
