<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Checkout;

enum Type: string
{
    case BRANCH = 'branch';

    case COMMIT = 'commit';
}
