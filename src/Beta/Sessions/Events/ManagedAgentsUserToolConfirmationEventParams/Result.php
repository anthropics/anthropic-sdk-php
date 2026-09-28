<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams;

/**
 * The confirmation result: 'allow' or 'deny'.
 */
enum Result: string
{
    case ALLOW = 'allow';

    case DENY = 'deny';
}
