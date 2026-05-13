<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultBlock;

enum Type: string
{
    case SEARCH_RESULT = 'search_result';
}
