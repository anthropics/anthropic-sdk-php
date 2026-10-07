<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

enum BetaComputerScrollDirection: string
{
    case UP = 'up';

    case DOWN = 'down';

    case LEFT = 'left';

    case RIGHT = 'right';
}
