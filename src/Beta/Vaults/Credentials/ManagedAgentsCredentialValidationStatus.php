<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

/**
 * Overall verdict of a credential validation probe.
 */
enum ManagedAgentsCredentialValidationStatus: string
{
    /**
     * The credential successfully authenticated against its MCP server.
     */
    case VALID = 'valid';

    /**
     * The probe reached the MCP server and was rejected, and a refresh (if attempted) did not recover it.
     */
    case INVALID = 'invalid';

    /**
     * The probe could not determine validity — for example, a transport error or a successful refresh that was not re-probed.
     */
    case UNKNOWN = 'unknown';
}
