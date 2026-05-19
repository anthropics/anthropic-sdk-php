<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\EnvironmentUpdateParams;

/**
 * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only.
 */
enum Scope: string
{
    case ORGANIZATION = 'organization';

    case ACCOUNT = 'account';
}
