<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

/**
 * Overall verdict of a credential validation probe.
 */
enum ManagedAgentsCredentialValidationStatus: string
{
    case VALID = 'valid';

    case INVALID = 'invalid';

    case UNKNOWN = 'unknown';
}
