<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

final class IdentityTokenLiteral implements IdentityTokenProvider
{
    public function __construct(private readonly string $token) {}

    public function getIdentityToken(): string
    {
        return $this->token;
    }
}
