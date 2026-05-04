<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

interface AccessTokenProvider
{
    /**
     * Fetch an access token. Re-invoking this method is the refresh mechanism.
     */
    public function fetchToken(): AccessToken;
}
