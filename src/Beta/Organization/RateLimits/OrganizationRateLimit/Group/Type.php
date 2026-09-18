<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit\Group;

enum Type: string
{
    case MODEL_GROUP = 'model_group';

    case BATCH = 'batch';

    case TOKEN_COUNT = 'token_count';

    case FILES = 'files';

    case SKILLS = 'skills';

    case WEB_SEARCH = 'web_search';
}
