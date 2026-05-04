<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

interface IdentityTokenProvider
{
    /**
     * Return the raw external identity token (e.g., an OIDC JWT).
     */
    public function getIdentityToken(): string;
}
