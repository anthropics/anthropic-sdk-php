<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMessageThreadParam;

enum Type: string
{
    case CREATE = 'create';

    case CONTINUE = 'continue';
}
