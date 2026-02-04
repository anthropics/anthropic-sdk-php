<?php

declare(strict_types=1);

namespace Anthropic\Vertex;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\Vertex\Services\MessagesRawService;
use Anthropic\Vertex\Services\MessagesService;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\ProjectIdProviderInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @phpstan-type GoogleAuthTokenShape = array{access_token: non-empty-string, expires_at: positive-int|null}
 */
final class Client extends BaseClient
{
    private const TOKEN_REFRESH_BUFFER_SECONDS = 300;
    private const PROJECT_ID_ENV_VARS = [
        'GOOGLE_CLOUD_PROJECT',
        'GCLOUD_PROJECT',
        'GOOGLE_CLOUD_PROJECT_ID',
    ];

    public MessagesService $messages;

    private ?FetchAuthTokenInterface $credentials = null;

    /**
     * @var GoogleAuthTokenShape|null
     */
    private ?array $lastToken = null;

    /**
     * @param \Closure(): FetchAuthTokenInterface $credentialsProvider
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     */
    private function __construct(
        private \Closure $credentialsProvider,
        private string $location,
        private ?string $projectId,
    ) {
        $options = RequestOptions::with(
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            transporter: Psr18ClientDiscovery::find(),
        );

        // @see https://docs.cloud.google.com/vertex-ai/docs/reference/rest#rest_endpoints
        $baseUrl = 'https://'.$location.'-aiplatform.googleapis.com';

        parent::__construct(
            headers: [],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->messages = new MessagesService(new MessagesRawService($this));
    }

    /**
     * @param non-empty-string $location
     * @param non-empty-string|null $projectId
     */
    public static function fromEnvironment(string $location, ?string $projectId = null): self
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
        );
    }

    public function getApiEndpoint(): string
    {
        $projectId = $this->resolveProjectId();

        return "/v1/projects/{$projectId}/locations/{$this->location}/publishers/anthropic/models";
    }

    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', 'Bearer '.$this->authToken()['access_token']);
    }

    private function resolveCredentials(): FetchAuthTokenInterface
    {
        if (null !== $this->credentials) {
            return $this->credentials;
        }

        return $this->credentials = ($this->credentialsProvider)();
    }

    /**
     * Resolve the project ID to be used for API requests.
     *
     * Project ID resolution precedence:
     * 1. Explicit project ID provided to constructor
     * 2. Environment variables (GOOGLE_CLOUD_PROJECT, GCLOUD_PROJECT, GOOGLE_CLOUD_PROJECT_ID)
     * 3. Project ID from Google credentials provider
     *
     * This precedence ensures that explicit configuration takes priority over environment,
     * and environment takes priority over credential discovery, allowing users to override
     * the project ID when needed for testing or multi-project scenarios.
     *
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
