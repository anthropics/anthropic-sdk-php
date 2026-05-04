<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

final class StaticToken implements AccessTokenProvider
{
    public function __construct(private readonly string $token) {}

    public function fetchToken(): AccessToken
    {
        return new AccessToken($this->token);
    }
}
