<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaBrowserClickTarget;

enum Type: string
{
    case COORDINATE = 'coordinate';

    case REF = 'ref';
}
