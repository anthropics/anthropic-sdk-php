<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchURLSources\ServerToolResults;

enum Type: string
{
    case ALL = 'all';

    case NONE = 'none';

    case ONLY = 'only';

    case EXCEPT = 'except';
}
