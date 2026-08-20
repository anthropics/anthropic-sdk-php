<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackParam\Thinking;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';

    case ADAPTIVE = 'adaptive';
}
