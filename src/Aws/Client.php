<?php

declare(strict_types=1);

namespace Anthropic\Aws;

use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Psr\Http\Message\RequestInterface;

/**
 * Anthropic AWS gateway client.
 *
 * Connects to the Anthropic AWS gateway at https://aws-external-anthropic.{region}.api.aws
 * with support for x-api-key auth and AWS SigV4 signing.
 *
 * Auth is resolved by precedence:
 *  0. $skipAuth (no auth — skips all below)
 *  1. $apiKey arg (x-api-key header)
 *  2. $awsAccessKey + $awsSecretAccessKey args (SigV4)
 *  3. $awsProfile arg (SigV4 via named profile)
 *  4. ANTHROPIC_AWS_API_KEY env var (x-api-key header)
 *  5. Default AWS credential chain (SigV4)
 *
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
class Client extends \Anthropic\Client
{
    private AwsAuth $auth;

    private ?string $resolvedWorkspaceId;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $awsAccessKey = null,
        ?string $awsSecretAccessKey = null,
        ?string $awsSessionToken = null,
        ?string $awsProfile = null,
        ?string $awsRegion = null,
        ?string $workspaceId = null,
        ?string $baseUrl = null,
        bool $skipAuth = false,
        RequestOptions|array|null $requestOptions = null,
    ) {
        // WorkspaceID: arg > env, required (unless skipAuth)
        $this->resolvedWorkspaceId = $workspaceId ?? Util::getenv('ANTHROPIC_AWS_WORKSPACE_ID');

        if (!$skipAuth && null === $this->resolvedWorkspaceId) {
            throw new \InvalidArgumentException(
                'No workspace ID found; set $workspaceId or ANTHROPIC_AWS_WORKSPACE_ID'
            );
        }

        $this->auth = new AwsAuth(
            serviceName: 'aws-external-anthropic',
            baseUrlPattern: 'https://aws-external-anthropic.{region}.api.aws',
            apiKeyEnvVar: 'ANTHROPIC_AWS_API_KEY',
            baseUrlEnvVar: 'ANTHROPIC_AWS_BASE_URL',
            apiKey: $apiKey,
            awsAccessKey: $awsAccessKey,
            awsSecretAccessKey: $awsSecretAccessKey,
            awsSessionToken: $awsSessionToken,
            awsProfile: $awsProfile,
            awsRegion: $awsRegion,
            baseUrl: $baseUrl,
            skipAuth: $skipAuth,
        );

        // Pass '' for apiKey and authToken to suppress ANTHROPIC_API_KEY and
        // ANTHROPIC_AUTH_TOKEN env var lookups. Auth is handled entirely by
        // AwsAuth in this class.
        parent::__construct(
            apiKey: '',
            authToken: '',
            baseUrl: $this->auth->getBaseUrl(),
            requestOptions: $requestOptions,
        );

        // Restore the resolved API key so the public field matches what
        // users passed in, rather than the empty string used above.
        $this->apiKey = $this->auth->getResolvedApiKey() ?? '';
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return $this->auth->getAuthHeaders();
    }

    /**
     * Applies workspace-id header (not overridable by user headers) and
     * signs the request with SigV4 if configured.
     */
    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        if (null !== $this->resolvedWorkspaceId) {
            $request = $request->withHeader('anthropic-workspace-id', $this->resolvedWorkspaceId);
        }

        return $this->auth->signRequest($request);
    }
}
