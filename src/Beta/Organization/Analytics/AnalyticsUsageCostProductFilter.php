<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

/**
 * Publicly documented product surfaces. `claude_tag` is Claude Tag, the Claude product in Slack. `chat_cowork_unified` is Chat and Cowork unified, Cowork's features inside claude.ai chat: chat and Cowork usage by a member who has it turned on is reported under this value instead of `chat` or `cowork`. It is accepted as a filter only on deployments that offer Chat and Cowork unified.
 */
enum AnalyticsUsageCostProductFilter: string
{
    case CHAT = 'chat';

    case CHAT_COWORK_UNIFIED = 'chat_cowork_unified';

    case CLAUDE_CODE = 'claude_code';

    case CLAUDE_CONSOLE = 'claude_console';

    case CLAUDE_DESIGN = 'claude_design';

    case CLAUDE_IN_CHROME = 'claude_in_chrome';

    case CLAUDE_TAG = 'claude_tag';

    case COWORK = 'cowork';

    case MANAGED_AGENTS_API = 'managed_agents_api';

    case MESSAGE_BATCHES_API = 'message_batches_api';

    case MESSAGES_API = 'messages_api';

    case OFFICE_AGENT = 'office_agent';
}
