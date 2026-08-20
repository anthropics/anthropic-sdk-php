<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMemoryTool20250818Command;

enum Command: string
{
    case VIEW = 'view';

    case CREATE = 'create';

    case STR_REPLACE = 'str_replace';

    case INSERT = 'insert';

    case DELETE = 'delete';

    case RENAME = 'rename';
}
