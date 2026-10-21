<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaSystemMessageParam\Content\Block;

enum Type: string
{
    case TEXT = 'text';

    case TOOL_ADDITION = 'tool_addition';

    case TOOL_REMOVAL = 'tool_removal';
}
