<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

final class AccessToken
{
    /**
     * @param int|null $expiresAt unix timestamp when the token expires, or null for no expiry
     */
    public function __construct(
        public readonly string $token,
        public readonly ?int $expiresAt = null,
    ) {}

    public function isExpired(int $bufferSeconds = 0): bool
    {
        if (is_null($this->expiresAt)) {
            return false;
        }

        return $this->expiresAt <= (time() + $bufferSeconds);
    }
}
