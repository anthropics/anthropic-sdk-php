<?php

declare(strict_types=1);

namespace Anthropic\Vertex;

use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\ProjectIdProviderInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @phpstan-type GoogleAuthTokenShape = array{access_token: non-empty-string, expires_at: positive-int|null}
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class Client extends \Anthropic\Client
{
    private const TOKEN_REFRESH_BUFFER_SECONDS = 300;
    private const PROJECT_ID_ENV_VARS = [
        'GOOGLE_CLOUD_PROJECT',
        'GCLOUD_PROJECT',
        'GOOGLE_CLOUD_PROJECT_ID',
    ];

    private ?FetchAuthTokenInterface $credentials = null;

    /**
     * @var GoogleAuthTokenShape|null
     */
    private ?array $lastToken = null;

    /**
     * @param (\Closure(): FetchAuthTokenInterface)|null $credentialsProvider
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     * @param non-empty-string|null $accessToken
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    private function __construct(
        private ?\Closure $credentialsProvider,
        private string $location,
        private ?string $projectId,
        private ?string $accessToken = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $baseUrl ??= Util::getenv('ANTHROPIC_VERTEX_BASE_URL') ?: match ($location) {
            'global' => 'https://aiplatform.googleapis.com',
            'us' => 'https://aiplatform.us.rep.googleapis.com',
            'eu' => 'https://aiplatform.eu.rep.googleapis.com',
            default => 'https://'.$location.'-aiplatform.googleapis.com',
        };

        // Pass '' for apiKey/authToken to suppress ANTHROPIC_API_KEY and
        // ANTHROPIC_AUTH_TOKEN env lookups; Vertex auth is handled entirely
        // by the $authorize closure in backendMiddleware().
        parent::__construct(
            apiKey: '',
            authToken: '',
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
        );
    }

    /**
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    public static function fromEnvironment(string $location, ?string $projectId = null, ?string $baseUrl = null, RequestOptions|array|null $requestOptions = null): self
    {
        self::ensureGoogleAuthLibraryIsInstalled();

        $credentialsProvider = function () {
            return ApplicationDefaultCredentials::getCredentials(
                scope: ['https://www.googleapis.com/auth/cloud-platform'],
            );
        };

        return new self(
            credentialsProvider: $credentialsProvider,
            location: $location,
            projectId: $projectId,
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
        );
    }

    /**
     * @param non-empty-string $accessToken
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    public static function withAccessToken(string $accessToken, string $location, ?string $projectId = null, ?string $baseUrl = null, RequestOptions|array|null $requestOptions = null): self
    {
        return new self(
            credentialsProvider: null,
            location: $location,
            projectId: $projectId,
            accessToken: $accessToken,
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
        );
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [];
    }

    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        return $request;
    }

    protected function backendMiddleware(): array
    {
        assert(null !== $this->options->streamFactory);

        return [new VertexMiddleware(
            $this->options->streamFactory,
            $this->location,
            $this->resolveProjectId(...),
            fn (RequestInterface $request): RequestInterface => $request->hasHeader('Authorization')
                ? $request
                : $request->withHeader('Authorization', 'Bearer '.$this->authToken()['access_token']),
        )];
    }

    private function resolveCredentials(): ?FetchAuthTokenInterface
    {
        if (null !== $this->credentials) {
            return $this->credentials;
        }
        if (null === $this->credentialsProvider) {
            return null;
        }

        return $this->credentials = ($this->credentialsProvider)();
    }

    /**
     * @return non-empty-string
     */
    private function resolveProjectId(): string
    {
        if (null !== $this->projectId) {
            return $this->projectId;
        }

        foreach (self::PROJECT_ID_ENV_VARS as $envVar) {
            if ($projectId = Util::getenv($envVar)) {
                return $this->projectId = $projectId;
            }
        }

        if (null === $this->credentials) {
            $this->credentials = $this->resolveCredentials();
        }

        if ($this->credentials instanceof ProjectIdProviderInterface) {
            $projectId = $this->credentials->getProjectId();

            if (is_string($projectId) && '' !== $projectId) {
                return $this->projectId = $projectId;
            }
        }

        throw new \RuntimeException(
            'Project ID could not be determined. Set one of these environment variables: '.implode(', ', self::PROJECT_ID_ENV_VARS).', or provide project_id option.'
        );
    }

    /**
     * @return GoogleAuthTokenShape
     */
    private function authToken(): array
    {
        if (null !== $this->accessToken) {
            return ['access_token' => $this->accessToken, 'expires_at' => null];
        }

        if (null === $this->lastToken || $this->isTokenExpired($this->lastToken)) {
            $this->lastToken = $this->fetchAuthToken();
        }

        return $this->lastToken;
    }

    /**
     * @param GoogleAuthTokenShape $token
     */
    private function isTokenExpired(array $token): bool
    {
        if (null === $token['expires_at']) {
            return false; // Token without expiration is valid
        }

        // Refresh if token expires within buffer period
        return $token['expires_at'] <= (time() + self::TOKEN_REFRESH_BUFFER_SECONDS);
    }

    /**
     * @return GoogleAuthTokenShape
     */
    private function fetchAuthToken(): array
    {
        $credentials = $this->resolveCredentials();
        if (null === $credentials) {
            throw new \RuntimeException('No access token or Google credentials configured.');
        }
        $token = $credentials->fetchAuthToken();

        $accessToken = $token['access_token'] ?? null;
        $expiresAt = $token['expires_at'] ?? null;

        if (is_string($accessToken) && '' !== $accessToken) {
            return [
                'access_token' => $accessToken,
                'expires_at' => is_int($expiresAt) && $expiresAt > 0 ? $expiresAt : null,
            ];
        }

        throw new \RuntimeException('Failed to fetch access token from credentials.');
    }

    private static function ensureGoogleAuthLibraryIsInstalled(): void
    {
        if (!interface_exists(FetchAuthTokenInterface::class)) {
            throw new \RuntimeException(
                'The Google Auth library is required to use Vertex. Please install `google/auth` via Composer.'
            );
        }
    }
}
