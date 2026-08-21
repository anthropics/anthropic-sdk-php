<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Lib\Credentials\Contracts\Closeable;

final class CredentialResult
{
    /**
     * @param array<string,string> $extraHeaders Additional headers to include on every API request (e.g., workspace-id).
     * @param string|null $baseUrl API base URL pinned by the credential source (e.g., a profile's base_url). Used only when no base URL is passed to the client or set via ANTHROPIC_BASE_URL.
     */
    public function __construct(
        public readonly AccessTokenProvider $provider,
        public readonly array $extraHeaders = [],
        public readonly ?string $baseUrl = null,
    ) {}

    public function close(): void
    {
        if ($this->provider instanceof Closeable) {
            $this->provider->close();
        }
    }
}
