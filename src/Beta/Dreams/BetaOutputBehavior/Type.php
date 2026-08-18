<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\BetaOutputBehavior;

enum Type: string
{
    case CREATE_NEW = 'create_new';

    case UPDATE_EXISTING = 'update_existing';
}
