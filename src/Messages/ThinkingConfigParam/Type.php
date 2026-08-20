<?php

declare(strict_types=1);

namespace Anthropic\Messages\ThinkingConfigParam;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';

    case ADAPTIVE = 'adaptive';
}
