<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaEnvironment;

/**
 * The visibility scope for this environment. 'organization' means visible to all accounts. 'account' means visible only to the owning account.
 */
enum Scope: string
{
    case ORGANIZATION = 'organization';

    case ACCOUNT = 'account';
}
