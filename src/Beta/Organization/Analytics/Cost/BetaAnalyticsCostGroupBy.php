<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

enum BetaAnalyticsCostGroupBy: string
{
    case ACTOR = 'actor';

    case ACTOR_TYPE = 'actor_type';

    case AGENT_ID = 'agent_id';

    case API_KEY_ID = 'api_key_id';

    case CLAUDE_TAG_CATEGORY = 'claude_tag_category';

    case CLAUDE_TAG_USER_ID = 'claude_tag_user_id';

    case CONTEXT_WINDOW = 'context_window';

    case COST_TYPE = 'cost_type';

    case DEPLOYMENT_ID = 'deployment_id';

    case ENVIRONMENT_ID = 'environment_id';

    case INFERENCE_GEO = 'inference_geo';

    case MODEL = 'model';

    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case SERVICE_TIER = 'service_tier';

    case SESSION_ID = 'session_id';

    case SLACK_CHANNEL_ID = 'slack_channel_id';

    case SPEED = 'speed';

    case TOKEN_TYPE = 'token_type';

    case USER_PROFILE_ID = 'user_profile_id';

    case WORKSPACE_ID = 'workspace_id';
}
