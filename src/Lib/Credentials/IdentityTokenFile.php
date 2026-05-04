<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

final class IdentityTokenFile implements IdentityTokenProvider
{
    public function __construct(private readonly string $path) {}

    public function getIdentityToken(): string
    {
        $token = @file_get_contents($this->path);
        if (false === $token) {
            throw new \RuntimeException("Failed to read identity token from {$this->path}");
        }

        return trim($token);
    }
}
