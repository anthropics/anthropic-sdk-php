<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Content;

enum Type: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case DOCUMENT = 'document';

    case SEARCH_RESULT = 'search_result';
}
