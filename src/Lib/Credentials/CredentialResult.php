<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Lib\Credentials\Contracts\Closeable;

final class CredentialResult
{
    /**
     * @param array<string,string> $extraHeaders Additional headers to include on every API request (e.g., workspace-id).
     */
    public function __construct(
        public readonly AccessTokenProvider $provider,
        public readonly array $extraHeaders = [],
    ) {}

    public function close(): void
    {
        if ($this->provider instanceof Closeable) {
            $this->provider->close();
        }
    }
}
