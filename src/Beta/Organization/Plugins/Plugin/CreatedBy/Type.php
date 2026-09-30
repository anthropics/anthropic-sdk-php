<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin\CreatedBy;

enum Type: string
{
    case USER_ACTOR = 'user_actor';

    case API_ACTOR = 'api_actor';
}
