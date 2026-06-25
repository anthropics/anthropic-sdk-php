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
 * Supported on Vertex: `$messages` (create / createStream / countTokens) and
 * `$beta->messages`. Other resources inherited from {@see \Anthropic\Client}
 * (batches, files, models, agents) are not available via Vertex and throw an
 * {@see \Anthropic\Core\Exceptions\AnthropicException} before any request is
 * sent — use `new \Anthropic\Client()` for those.
 *
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
     * @param \Closure(): FetchAuthTokenInterface $credentialsProvider
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     * @param non-empty-string|null $baseUrl
     * @param RequestOpts|null $requestOptions
     */
    private function __construct(
        private \Closure $credentialsProvider,
        private string $location,
        private ?string $projectId,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $baseUrl ??= Util::getenv('ANTHROPIC_VERTEX_BASE_URL') ?: match ($location) {
            'global' => 'https://aiplatform.googleapis.com/v1',
            'us' => 'https://aiplatform.us.rep.googleapis.com/v1',
            'eu' => 'https://aiplatform.eu.rep.googleapis.com/v1',
            default => 'https://'.$location.'-aiplatform.googleapis.com/v1',
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

        return new self(
            credentialsProvider: static fn (): FetchAuthTokenInterface => ApplicationDefaultCredentials::getCredentials(
                scope: ['https://www.googleapis.com/auth/cloud-platform'],
            ),
            location: $location,
            projectId: $projectId,
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
    public static function withCredentials(FetchAuthTokenInterface $credentials, string $location, ?string $projectId = null, ?string $baseUrl = null, RequestOptions|array|null $requestOptions = null): self
    {
        return new self(
            credentialsProvider: static fn (): FetchAuthTokenInterface => $credentials,
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
        return self::withCredentials(
            new StaticAccessToken($accessToken),
            location: $location,
            projectId: $projectId,
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

    private function resolveCredentials(): FetchAuthTokenInterface
    {
        return $this->credentials ??= ($this->credentialsProvider)();
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

        $credentials = $this->resolveCredentials();
        if ($credentials instanceof ProjectIdProviderInterface) {
            $projectId = $credentials->getProjectId();
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
        $token = $this->resolveCredentials()->fetchAuthToken();

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

/** @internal */
final class StaticAccessToken implements FetchAuthTokenInterface
{
    /** @param non-empty-string $token */
    public function __construct(private string $token) {}

    public function fetchAuthToken(?callable $httpHandler = null): array
    {
        return ['access_token' => $this->token];
    }

    public function getCacheKey(): ?string
    {
        return null;
    }

    /** @return array{access_token: string} */
    public function getLastReceivedToken(): array
    {
        return ['access_token' => $this->token];
    }
}
