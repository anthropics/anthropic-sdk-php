<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageParam;

enum Role: string
{
    case USER = 'user';

    case ASSISTANT = 'assistant';
}
