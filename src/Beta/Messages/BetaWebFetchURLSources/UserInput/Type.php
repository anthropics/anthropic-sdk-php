<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchURLSources\UserInput;

enum Type: string
{
    case ALL = 'all';

    case NONE = 'none';
}
