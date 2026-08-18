<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolChoice;

enum Type: string
{
    case AUTO = 'auto';

    case ANY = 'any';

    case TOOL = 'tool';

    case NONE = 'none';
}
