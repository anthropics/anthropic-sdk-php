<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshObject;

/**
 * Outcome of a refresh-token exchange attempted during credential validation.
 */
enum Status: string
{
    case SUCCEEDED = 'succeeded';

    case FAILED = 'failed';

    case CONNECT_ERROR = 'connect_error';

    case NO_REFRESH_TOKEN = 'no_refresh_token';
}
