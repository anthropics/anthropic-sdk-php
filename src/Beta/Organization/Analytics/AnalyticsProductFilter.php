<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

/**
 * Publicly documented product surfaces. `claude-tag` is Claude Tag, the Claude product in Slack.
 */
enum AnalyticsProductFilter: string
{
    case CHAT = 'chat';

    case CLAUDE_TAG = 'claude-tag';

    case CLAUDE_CODE = 'claude_code';

    case CLAUDE_DESIGN = 'claude_design';

    case CLAUDE_IN_CHROME = 'claude_in_chrome';

    case COWORK = 'cowork';

    case OFFICE_AGENT = 'office_agent';
}
