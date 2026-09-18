<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;

/**
 * Deprecated: use `group.type` instead. The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`. Always equal to `group.type`.
 *
 * @deprecated Use `group.type` instead. `group_type` is still returned and always equals `group.type`.
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
