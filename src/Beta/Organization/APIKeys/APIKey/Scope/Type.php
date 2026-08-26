<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys\APIKey\Scope;

enum Type: string
{
    case ORGANIZATION = 'organization';

    case WORKSPACE = 'workspace';
}
