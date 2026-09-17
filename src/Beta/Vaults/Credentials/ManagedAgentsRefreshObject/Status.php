<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshObject;

/**
 * Outcome of a refresh-token exchange attempted during credential validation.
 */
enum Status: string
{
    /**
     * The token endpoint returned a new access token.
     */
    case SUCCEEDED = 'succeeded';

    /**
     * The token endpoint returned an error response. See `http_response` for detail.
     */
    case FAILED = 'failed';

    /**
     * The token endpoint could not be reached (DNS, TLS, or connection error).
     */
    case CONNECT_ERROR = 'connect_error';

    /**
     * No refresh token is stored for the credential, so no exchange was attempted.
     */
    case NO_REFRESH_TOKEN = 'no_refresh_token';
}
