<?php

declare(strict_types=1);

namespace Anthropic\Messages;

enum WebFetchToolResultErrorCode: string
{
    case INVALID_TOOL_INPUT = 'invalid_tool_input';

    case URL_TOO_LONG = 'url_too_long';

    case URL_NOT_ALLOWED = 'url_not_allowed';

    case URL_NOT_ACCESSIBLE = 'url_not_accessible';

    case UNSUPPORTED_CONTENT_TYPE = 'unsupported_content_type';

    case TOO_MANY_REQUESTS = 'too_many_requests';

    case MAX_USES_EXCEEDED = 'max_uses_exceeded';

    case UNAVAILABLE = 'unavailable';
}
