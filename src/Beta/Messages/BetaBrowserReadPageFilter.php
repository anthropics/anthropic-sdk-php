<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

enum BetaBrowserReadPageFilter: string
{
    case ALL = 'all';

    case INTERACTIVE = 'interactive';
}
