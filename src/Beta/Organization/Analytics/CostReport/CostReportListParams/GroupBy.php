<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams;

enum GroupBy: string
{
    case CLAUDE_TAG_CATEGORY = 'claude_tag_category';

    case CLAUDE_TAG_USER_ID = 'claude_tag_user_id';

    case CONTEXT_WINDOW = 'context_window';

    case COST_TYPE = 'cost_type';

    case INFERENCE_GEO = 'inference_geo';

    case MODEL = 'model';

    case PRODUCT = 'product';

    case RBAC_GROUP_ID = 'rbac_group_id';

    case SLACK_CHANNEL_ID = 'slack_channel_id';

    case SPEED = 'speed';

    case TOKEN_TYPE = 'token_type';
}
