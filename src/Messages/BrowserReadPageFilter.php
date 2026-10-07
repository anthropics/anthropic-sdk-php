<?php

declare(strict_types=1);

namespace Anthropic\Messages;

enum BrowserReadPageFilter: string
{
    case ALL = 'all';

    case INTERACTIVE = 'interactive';
}
