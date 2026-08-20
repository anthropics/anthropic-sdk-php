<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsActor;

enum Type: string
{
    case SESSION_ACTOR = 'session_actor';

    case API_ACTOR = 'api_actor';

    case USER_ACTOR = 'user_actor';

    case SERVICE_ACCOUNT_ACTOR = 'service_account_actor';
}
