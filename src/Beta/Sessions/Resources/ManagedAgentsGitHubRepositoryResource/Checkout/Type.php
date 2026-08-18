<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout;

enum Type: string
{
    case BRANCH = 'branch';

    case COMMIT = 'commit';
}
