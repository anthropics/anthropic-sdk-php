<?php

declare(strict_types=1);

namespace Anthropic\Messages\ServerToolUseBlock;

enum Name: string
{
    case WEB_SEARCH = 'web_search';

    case WEB_FETCH = 'web_fetch';

    case CODE_EXECUTION = 'code_execution';

    case BASH_CODE_EXECUTION = 'bash_code_execution';

    case TEXT_EDITOR_CODE_EXECUTION = 'text_editor_code_execution';

    case TOOL_SEARCH_TOOL_REGEX = 'tool_search_tool_regex';

    case TOOL_SEARCH_TOOL_BM25 = 'tool_search_tool_bm25';
}
