<?php

declare(strict_types=1);

namespace Anthropic\GoogleCloud;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\ProjectIdProviderInterface;

/**
 * Google credential resolution for the GoogleCloud client.
 *
 * All references to the optional `google/auth` package are isolated here so
 * that loading {@see Client} does not fatal when the package is not installed.
 *
 * @internal
 *
 * @phpstan-type CachedToken = array{access_token: string, expires_at: int|null}
 */
final class GoogleAuth
{
    public const SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    private const TOKEN_REFRESH_BUFFER_SECONDS = 300;

    private ?FetchAuthTokenInterface $credentials;

    /** @var CachedToken|null */
    private ?array $lastToken = null;

    public function __construct(?object $credentials)
    {
        self::ensureInstalled();

        if (null !== $credentials && !$credentials instanceof FetchAuthTokenInterface) {
            throw new \InvalidArgumentException(
                '$googleCredentials must implement '.FetchAuthTokenInterface::class
            );
        }

        $this->credentials = $credentials;
    }

    /**
     * Returns a valid access token, fetching (or refreshing) via the underlying
     * credentials when no cached token exists or it expires within the buffer.
     */
    public function token(): string
    {
        if (null === $this->lastToken || $this->isExpired($this->lastToken)) {
            $this->lastToken = $this->fetchToken();
        }

        return $this->lastToken['access_token'];
    }

    /**
     * Returns the project ID from the resolved credentials, when the
     * credential implementation exposes one.
     */
    public function projectId(): ?string
    {
        $credentials = $this->credentials();

        if ($credentials instanceof ProjectIdProviderInterface) {
            $projectId = $credentials->getProjectId();
            if (is_string($projectId) && '' !== $projectId) {
                return $projectId;
            }
        }

        return null;
    }

    public static function ensureInstalled(): void
    {
        if (!interface_exists(FetchAuthTokenInterface::class)) {
            throw new \RuntimeException(
                'The Anthropic\GoogleCloud client requires the google/auth package. '
                .'Install it with: composer require google/auth'
            );
        }
    }

    private function credentials(): FetchAuthTokenInterface
    {
        return $this->credentials ??= ApplicationDefaultCredentials::getCredentials(scope: [self::SCOPE]);
    }

    /** @return CachedToken */
    private function fetchToken(): array
    {
        $token = $this->credentials()->fetchAuthToken();

        $accessToken = $token['access_token'] ?? null;
        if (!is_string($accessToken) || '' === $accessToken) {
            throw new \RuntimeException('Failed to fetch access token from Google credentials.');
        }

        $expiresAt = $token['expires_at'] ?? null;

        return [
            'access_token' => $accessToken,
            'expires_at' => is_numeric($expiresAt) ? (int) $expiresAt : null,
        ];
    }

    /** @param CachedToken $token */
    private function isExpired(array $token): bool
    {
        if (null === $token['expires_at']) {
            return false;
        }

        return $token['expires_at'] <= (time() + self::TOKEN_REFRESH_BUFFER_SECONDS);
    }
}
