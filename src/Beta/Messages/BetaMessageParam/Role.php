<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMessageParam;

enum Role: string
{
    case USER = 'user';

    case ASSISTANT = 'assistant';
}
