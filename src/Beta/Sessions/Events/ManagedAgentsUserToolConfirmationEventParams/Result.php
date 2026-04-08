<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams;

/**
 * UserToolConfirmationResult enum.
 */
enum Result: string
{
    case ALLOW = 'allow';

    case DENY = 'deny';
}
