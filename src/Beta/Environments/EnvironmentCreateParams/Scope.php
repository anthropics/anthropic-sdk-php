<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\EnvironmentCreateParams;

/**
 * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only. API organizations support only 'organization'; 'account' is rejected. If not specified, defaults based on organization type.
 */
enum Scope: string
{
    case ORGANIZATION = 'organization';

    case ACCOUNT = 'account';
}
