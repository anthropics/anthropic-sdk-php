<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys\APIKey\Principal;

enum Type: string
{
    case USER_ACTOR = 'user_actor';

    case SERVICE_ACCOUNT_ACTOR = 'service_account_actor';
}
