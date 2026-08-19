<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam\Content\Content;

enum Type: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case SEARCH_RESULT = 'search_result';

    case DOCUMENT = 'document';

    case TOOL_REFERENCE = 'tool_reference';

    case BROWSER_STATE = 'browser_state';
}
