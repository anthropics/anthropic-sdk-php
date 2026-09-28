<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue\Source;

enum Type: string
{
    case WORKSPACE = 'workspace';

    case ORGANIZATION = 'organization';
}
