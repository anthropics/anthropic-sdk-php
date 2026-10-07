<?php

declare(strict_types=1);

namespace Anthropic\Messages;

enum BrowserScrollDirection: string
{
    case UP = 'up';

    case DOWN = 'down';

    case LEFT = 'left';

    case RIGHT = 'right';
}
