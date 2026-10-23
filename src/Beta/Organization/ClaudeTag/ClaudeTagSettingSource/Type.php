<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSource;

enum Type: string
{
    case SLACK_CHANNEL = 'slack_channel';

    case SLACK_WORKSPACE = 'slack_workspace';

    case SLACK_PARENT_CHANNEL = 'slack_parent_channel';

    case SLACK_DEFAULT = 'slack_default';

    case DEFAULT = 'default';

    case SLACK_GRID_CHANNEL = 'slack_grid_channel';
}
