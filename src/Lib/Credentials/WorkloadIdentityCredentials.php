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

final class WorkloadIdentityCredentials implements AccessTokenProvider, Closeable
{
    private const TOKEN_PATH = '/v1/oauth/token';
    private const GRANT_TYPE = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
    private const BETA_HEADER = 'oauth-2025-04-20,oidc-federation-2026-04-01';
    private const MAX_ERROR_LENGTH = 256;
    private const OAUTH_ERROR_FIELDS = ['error', 'error_description', 'error_uri'];

    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        private readonly IdentityTokenProvider $identityProvider,
        private readonly string $federationRuleId,
        private readonly string $organizationId,
        private readonly ?string $serviceAccountId = null,
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
        $assertion = $this->identityProvider->getIdentityToken();

        $body = [
            'grant_type' => self::GRANT_TYPE,
            'assertion' => $assertion,
            'federation_rule_id' => $this->federationRuleId,
            'organization_id' => $this->organizationId,
        ];

        if (!is_null($this->serviceAccountId)) {
            $body['service_account_id'] = $this->serviceAccountId;
        }

        $jsonBody = json_encode($body, flags: Util::JSON_ENCODE_FLAGS);
        $url = rtrim($this->tokenEndpointBaseUrl, '/').self::TOKEN_PATH;

        $request = $this->requestFactory->createRequest('POST', $url);
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('anthropic-beta', self::BETA_HEADER);
        $request = $request->withBody($this->streamFactory->createStream($jsonBody));

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new OAuthException(0, 'Token exchange request failed: '.$e->getMessage(), $e);
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
            throw new OAuthException($statusCode, 'Invalid JSON in token exchange response', $e);
        }

        $accessToken = $data['access_token'] ?? null;
        if (!is_string($accessToken) || '' === $accessToken) {
            throw new OAuthException($statusCode, 'Token exchange response missing access_token');
        }

        $expiresIn = $data['expires_in'] ?? null;
        $expiresAt = is_numeric($expiresIn) && (int) $expiresIn > 0
            ? time() + (int) $expiresIn
            : null;

        return new AccessToken($accessToken, $expiresAt);
    }

    public function close(): void
    {
        // No-op — PSR-18 clients don't have a standard close mechanism.
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
        $message = "Token exchange failed with status {$statusCode}";

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
