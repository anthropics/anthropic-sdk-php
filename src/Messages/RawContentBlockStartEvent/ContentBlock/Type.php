<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawContentBlockStartEvent\ContentBlock;

enum Type: string
{
    case TEXT = 'text';

    case THINKING = 'thinking';

    case REDACTED_THINKING = 'redacted_thinking';

    case TOOL_USE = 'tool_use';

    case SERVER_TOOL_USE = 'server_tool_use';

    case WEB_SEARCH_TOOL_RESULT = 'web_search_tool_result';

    case WEB_FETCH_TOOL_RESULT = 'web_fetch_tool_result';

    case CODE_EXECUTION_TOOL_RESULT = 'code_execution_tool_result';

    case BASH_CODE_EXECUTION_TOOL_RESULT = 'bash_code_execution_tool_result';

    case TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT = 'text_editor_code_execution_tool_result';

    case TOOL_SEARCH_TOOL_RESULT = 'tool_search_tool_result';

    case CONTAINER_UPLOAD = 'container_upload';
}
