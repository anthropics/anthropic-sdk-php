<?php

declare(strict_types=1);

namespace Anthropic\Messages\BrowserClickTarget;

enum Type: string
{
    case COORDINATE = 'coordinate';

    case REF = 'ref';
}
