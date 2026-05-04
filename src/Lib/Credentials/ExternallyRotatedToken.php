<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

/**
 * Reads an access token from a credentials file on every call.
 *
 * Used for user_oauth profiles without a client_id, where an external
 * process (e.g., CLI login) rotates the tokens in the credentials file.
 */
final class ExternallyRotatedToken implements AccessTokenProvider
{
    public function __construct(private readonly string $credentialsFilePath) {}

    public function fetchToken(): AccessToken
    {
        $content = @file_get_contents($this->credentialsFilePath);
        if (false === $content) {
            throw new \RuntimeException("Failed to read credentials file: {$this->credentialsFilePath}");
        }

        try {
            /** @var array<string,mixed> $data */
            $data = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException("Invalid JSON in credentials file: {$this->credentialsFilePath}", 0, $e);
        }

        $accessToken = $data['access_token'] ?? null;
        if (!is_string($accessToken) || '' === $accessToken) {
            throw new \RuntimeException("Credentials file missing access_token: {$this->credentialsFilePath}");
        }

        $expiresAt = $data['expires_at'] ?? null;
        $expiresAt = is_numeric($expiresAt) && (int) $expiresAt > 0 ? (int) $expiresAt : null;

        return new AccessToken($accessToken, $expiresAt);
    }
}
