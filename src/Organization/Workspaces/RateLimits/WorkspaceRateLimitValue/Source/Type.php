<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitValue\Source;

enum Type: string
{
    case WORKSPACE = 'workspace';

    case ORGANIZATION = 'organization';
}
