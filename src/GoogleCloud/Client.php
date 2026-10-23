<?php

declare(strict_types=1);

namespace Anthropic\GoogleCloud;

use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Google\Auth\FetchAuthTokenInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Client for Claude Models on Google Cloud (Anthropic managed).
 *
 * Connects to the Anthropic Google Cloud gateway and exposes the full base
 * client surface ({@see \Anthropic\Client}) authenticated with a Google
 * access token.
 *
 * Auth is resolved by precedence:
 *  0. $skipAuth (no auth — skips all below)
 *  1. $tokenProvider arg (closure returning a bearer token string)
 *  2. $googleCredentials arg ({@see FetchAuthTokenInterface})
 *  3. Google Application Default Credentials (cloud-platform scope)
 *
 * Project is resolved by precedence: $project arg > ANTHROPIC_GOOGLE_CLOUD_PROJECT
 * > GOOGLE_CLOUD_PROJECT > the resolved credentials' project ID (when available).
 *
 * Location is resolved by precedence: $location arg > ANTHROPIC_GOOGLE_CLOUD_LOCATION
 * > 'global'. The derived base URL includes the project, location, and workspace ID.
 * Organization-level routes (`v1/organizations/*` and `v1/user_profiles`) go to the
 * project's organization endpoint and need no workspace ID.
 *
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 */
final class Client extends \Anthropic\Client
{
    private const ORGANIZATION_PATH_PATTERN = '#^v1/(?:organizations/|user_profiles(?:[/?]|$))#D';

    private ?GoogleAuth $auth = null;

    /** @var (\Closure(): string)|null */
    private ?\Closure $tokenProvider = null;

    private ?string $workspaceId;

    /** Null when the base URL was given explicitly; that URL then takes every route. */
    private ?string $organizationBaseUrl = null;

    /**
     * @param FetchAuthTokenInterface|null $googleCredentials
     * @param (\Closure(): string)|null $tokenProvider
     * @param RequestOpts|null $requestOptions
     * @param OpenTelemetryOptions|null $openTelemetry
     */
    public function __construct(
        ?string $project = null,
        ?string $location = null,
        ?string $workspaceId = null,
        ?string $baseUrl = null,
        ?object $googleCredentials = null,
        ?\Closure $tokenProvider = null,
        private bool $skipAuth = false,
        RequestOptions|array|null $requestOptions = null,
        array|false|null $openTelemetry = null,
    ) {
        // Env reads collocated here so the client's environment requirements
        // are discoverable in one place. Explicit "" is preserved (no ?: "").
        $project ??= Util::getenv('ANTHROPIC_GOOGLE_CLOUD_PROJECT')
            ?? Util::getenv('GOOGLE_CLOUD_PROJECT');
        $location ??= Util::getenv('ANTHROPIC_GOOGLE_CLOUD_LOCATION') ?? 'global';
        $baseUrl ??= Util::getenv('ANTHROPIC_GOOGLE_CLOUD_BASE_URL');
        $this->workspaceId = $workspaceId ??= Util::getenv('ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID');

        if ($skipAuth) {
            if (null !== $googleCredentials || null !== $tokenProvider) {
                throw new \InvalidArgumentException(
                    '$skipAuth is mutually exclusive with $googleCredentials and $tokenProvider'
                );
            }
        } else {
            $this->tokenProvider = $tokenProvider;
            if (null === $tokenProvider) {
                $this->auth = new GoogleAuth($googleCredentials);
                $project ??= $this->auth->projectId();
            }
        }

        if (null === $baseUrl) {
            if (null === $project) {
                throw new \InvalidArgumentException(
                    'No project found; set $project, set the ANTHROPIC_GOOGLE_CLOUD_PROJECT environment variable, '
                    .'or configure application default credentials with a project'
                );
            }

            $locationUrl = "https://claude.googleapis.com/v1/projects/{$project}/locations/{$location}";
            $this->organizationBaseUrl = "{$locationUrl}/claudeOrganization/invoke";
            // Without a workspace ID only organization routes are reachable;
            // buildRequest() rejects every other route before it is sent.
            $baseUrl = null === $workspaceId
                ? $this->organizationBaseUrl
                : "{$locationUrl}/workspaces/{$workspaceId}/invoke";
        }

        // Pass '' for apiKey to suppress ANTHROPIC_API_KEY,
        // ANTHROPIC_AUTH_TOKEN, and credentials-file lookups in the base
        // client. Auth is handled entirely by transformRequest() below.
        parent::__construct(
            apiKey: '',
            baseUrl: $baseUrl,
            requestOptions: $requestOptions,
            openTelemetry: $openTelemetry,
        );
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [];
    }

    /**
     * Applies the Google bearer token. Idempotent — uses withHeader() so
     * retries get a fresh token rather than accumulating Authorization values.
     */
    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        if ($this->skipAuth) {
            return $request;
        }

        return $request->withHeader('Authorization', 'Bearer '.$this->bearerToken());
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions, string}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        $parsedPath = Util::parsePath($path);

        // A full URL, as the next page of a list carries, already names its endpoint.
        if (null !== $this->organizationBaseUrl && !preg_match('#^[A-Za-z][A-Za-z0-9+.-]*://#', $parsedPath)) {
            $relativePath = ltrim($parsedPath, '/');

            if (preg_match(self::ORGANIZATION_PATH_PATTERN, $relativePath)) {
                $path = "{$this->organizationBaseUrl}/{$relativePath}";
            } elseif (null === $this->workspaceId) {
                throw new \InvalidArgumentException(
                    'No workspace ID was given; set $workspaceId or the ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID environment variable'
                );
            }
        }

        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: $headers,
            body: $body,
            opts: $opts,
        );
    }

    private function bearerToken(): string
    {
        if (null !== $this->tokenProvider) {
            return ($this->tokenProvider)();
        }

        assert(null !== $this->auth);

        return $this->auth->token();
    }
}
