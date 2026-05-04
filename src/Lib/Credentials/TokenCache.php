<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

final class TokenCache implements AccessTokenProvider
{
    private const ADVISORY_REFRESH_SECONDS = 120;

    private ?AccessToken $cached = null;

    public function __construct(private readonly AccessTokenProvider $inner) {}

    public function fetchToken(): AccessToken
    {
        if (is_null($this->cached) || $this->cached->isExpired(self::ADVISORY_REFRESH_SECONDS)) {
            $this->cached = $this->inner->fetchToken();
        }

        return $this->cached;
    }

    public function invalidate(): void
    {
        $this->cached = null;
    }
}
