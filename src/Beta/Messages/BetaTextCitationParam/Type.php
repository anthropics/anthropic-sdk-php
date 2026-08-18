<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextCitationParam;

enum Type: string
{
    case CHAR_LOCATION = 'char_location';

    case PAGE_LOCATION = 'page_location';

    case CONTENT_BLOCK_LOCATION = 'content_block_location';

    case WEB_SEARCH_RESULT_LOCATION = 'web_search_result_location';

    case SEARCH_RESULT_LOCATION = 'search_result_location';
}
