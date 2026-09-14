<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchURLSources\UserInput;

enum Type: string
{
    case ALL = 'all';

    case NONE = 'none';
}
