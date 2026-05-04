<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Util;

final class EnvToken implements AccessTokenProvider
{
    public function __construct(private readonly string $envVar = 'ANTHROPIC_AUTH_TOKEN') {}

    public function fetchToken(): AccessToken
    {
        $token = Util::getenv($this->envVar);
        if (is_null($token) || '' === $token) {
            throw new \RuntimeException("Environment variable {$this->envVar} is not set");
        }

        return new AccessToken($token);
    }
}
