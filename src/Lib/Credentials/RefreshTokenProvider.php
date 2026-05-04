<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Util;
use Anthropic\Lib\Credentials\Contracts\Closeable;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class RefreshTokenProvider implements AccessTokenProvider, Closeable
{
    private const TOKEN_PATH = '/v1/oauth/token';
    private const BETA_HEADER = 'oauth-2025-04-20';
    private const MAX_ERROR_LENGTH = 256;
    private const OAUTH_ERROR_FIELDS = ['error', 'error_description', 'error_uri'];

    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        private readonly string $clientId,
        private string $refreshToken,
        private readonly string $credentialsFilePath,
        private readonly string $tokenEndpointBaseUrl = 'https://api.anthropic.com',
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        self::validateEndpointUrl($tokenEndpointBaseUrl);
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function fetchToken(): AccessToken
    {
        $body = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->clientId,
        ];

        $jsonBody = json_encode($body, flags: Util::JSON_ENCODE_FLAGS);
        $url = rtrim($this->tokenEndpointBaseUrl, '/').self::TOKEN_PATH;

        $request = $this->requestFactory->createRequest('POST', $url);
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('anthropic-beta', self::BETA_HEADER);
        $request = $request->withBody($this->streamFactory->createStream($jsonBody));

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new OAuthException(0, 'Refresh token request failed: '.$e->getMessage(), $e);
        }

        $statusCode = $response->getStatusCode();
        $responseBody = (string) $response->getBody();

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new OAuthException($statusCode, self::redactErrorBody($statusCode, $responseBody));
        }

        try {
            /** @var array<string,mixed> $data */
            $data = Util::decodeJson($responseBody);
        } catch (\JsonException $e) {
            throw new OAuthException($statusCode, 'Invalid JSON in refresh token response', $e);
        }

        $accessToken = $data['access_token'] ?? null;
        if (!is_string($accessToken) || '' === $accessToken) {
            throw new OAuthException($statusCode, 'Refresh token response missing access_token');
        }

        $expiresIn = $data['expires_in'] ?? null;
        $expiresAt = is_numeric($expiresIn) && (int) $expiresIn > 0
            ? time() + (int) $expiresIn
            : null;

        // Update the stored refresh token if a new one was provided.
        $newRefreshToken = $data['refresh_token'] ?? null;
        if (is_string($newRefreshToken) && '' !== $newRefreshToken) {
            $this->refreshToken = $newRefreshToken;
        }

        // Write updated tokens back to the credentials file atomically.
        $this->persistCredentials($accessToken, $expiresAt);

        return new AccessToken($accessToken, $expiresAt);
    }

    public function close(): void
    {
        // No-op — PSR-18 clients don't have a standard close mechanism.
    }

    private function persistCredentials(string $accessToken, ?int $expiresAt): void
    {
        $credentials = [
            'type' => 'oauth_token',
            'access_token' => $accessToken,
            'refresh_token' => $this->refreshToken,
        ];

        if (!is_null($expiresAt)) {
            $credentials['expires_at'] = $expiresAt;
        }

        $json = json_encode($credentials, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Atomic write: write to temp file then rename.
        $dir = dirname($this->credentialsFilePath);
        $tmpFile = tempnam($dir, '.cred_');
        if (false === $tmpFile) {
            return; // Silently skip persistence if temp file creation fails.
        }

        try {
            file_put_contents($tmpFile, $json);
            chmod($tmpFile, 0600);
            rename($tmpFile, $this->credentialsFilePath);
        } catch (\Throwable) {
            @unlink($tmpFile);
        }
    }

    private static function validateEndpointUrl(string $url): void
    {
        $parsed = parse_url($url);
        $scheme = $parsed['scheme'] ?? '';
        $host = $parsed['host'] ?? '';

        if ('https' === $scheme) {
            return;
        }

        if ('http' === $scheme && in_array($host, ['localhost', '127.0.0.1'], true)) {
            return;
        }

        throw new \InvalidArgumentException(
            "Token endpoint URL must use HTTPS (got: {$url}). HTTP is only allowed for localhost."
        );
    }

    private static function redactErrorBody(int $statusCode, string $responseBody): string
    {
        $message = "Refresh token exchange failed with status {$statusCode}";

        if ('' === $responseBody) {
            return $message;
        }

        try {
            /** @var array<string,mixed> $data */
            $data = json_decode($responseBody, associative: true, flags: JSON_THROW_ON_ERROR);
            $redacted = array_intersect_key($data, array_flip(self::OAUTH_ERROR_FIELDS));

            if ([] !== $redacted) {
                $detail = json_encode($redacted, flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '';
            } else {
                $detail = mb_substr($responseBody, 0, self::MAX_ERROR_LENGTH);
            }
        } catch (\JsonException) {
            $detail = mb_substr($responseBody, 0, self::MAX_ERROR_LENGTH);
        }

        if (mb_strlen($detail) > self::MAX_ERROR_LENGTH) {
            $detail = mb_substr($detail, 0, self::MAX_ERROR_LENGTH).'...';
        }

        return "{$message}: {$detail}";
    }
}
