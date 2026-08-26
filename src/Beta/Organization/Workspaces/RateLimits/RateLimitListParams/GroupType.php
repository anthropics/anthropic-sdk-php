<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams;

/**
 * Filter by group type.
 */
enum GroupType: string
{
    case BATCH = 'batch';

    case FILES = 'files';

    case MODEL_GROUP = 'model_group';

    case SKILLS = 'skills';

    case TOKEN_COUNT = 'token_count';

    case WEB_SEARCH = 'web_search';
}
