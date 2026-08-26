<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;

/**
 * The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`.
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
