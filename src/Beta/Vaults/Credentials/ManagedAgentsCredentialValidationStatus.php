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
     * The probe reached the MCP server and the server rejected the credential, or no access token is stored. A refresh, if one was tried, didn't recover it. Usually the end user needs to authorize again.
     */
    case INVALID = 'invalid';

    /**
     * The probe couldn't tell whether the credential works, for example because of a network error or because a refresh succeeded but the new access token wasn't tested. Validate the credential again to find out.
     */
    case UNKNOWN = 'unknown';
}
