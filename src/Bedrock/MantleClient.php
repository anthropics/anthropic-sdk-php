<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Aws\AwsAuth;
use Anthropic\Bedrock\Services\MantleMessagesService;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\RequestInterface;

use const Anthropic\VERSION;

/**
 * Anthropic Bedrock Mantle client.
 *
 * Connects to the Bedrock Mantle gateway at
 * https://bedrock-mantle.{region}.api.aws/anthropic with support for
 * x-api-key auth and AWS SigV4 signing.
 *
 * Only the /v1/messages endpoint (and subpaths) are supported.
 *
 * Auth is resolved by precedence:
 *  0. $skipAuth (no auth — skips all below)
 *  1. $apiKey arg (x-api-key header)
 *  2. $awsAccessKey + $awsSecretAccessKey args (SigV4)
 *  3. $awsProfile arg (SigV4 via named profile)
 *  4. AWS_BEARER_TOKEN_BEDROCK env var (x-api-key header)
 *  5. ANTHROPIC_AWS_API_KEY env var fallback (x-api-key header)
 *  6. Default AWS credential chain (SigV4)
 *
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MantleClient extends BaseClient
{
    /**
     * @api
     */
    public MantleMessagesService $messages;
    private AwsAuth $auth;

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
        ?string $baseUrl = null,
        bool $skipAuth = false,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->auth = new AwsAuth(
            serviceName: 'bedrock-mantle',
            baseUrlPattern: 'https://bedrock-mantle.{region}.api.aws/anthropic',
            apiKeyEnvVar: 'AWS_BEARER_TOKEN_BEDROCK',
            baseUrlEnvVar: 'ANTHROPIC_BEDROCK_MANTLE_BASE_URL',
            apiKeyFallbackEnvVar: 'ANTHROPIC_AWS_API_KEY',
            apiKey: $apiKey,
            awsAccessKey: $awsAccessKey,
            awsSecretAccessKey: $awsSecretAccessKey,
            awsSessionToken: $awsSessionToken,
            awsProfile: $awsProfile,
            awsRegion: $awsRegion,
            baseUrl: $baseUrl,
            skipAuth: $skipAuth,
        );

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        parent::__construct(
            headers: [
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => sprintf('anthropic/PHP %s', VERSION),
                'X-Stainless-Lang' => 'php',
                'X-Stainless-Package-Version' => '0.0.1',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $this->auth->getBaseUrl(),
            options: $options,
        );

        $this->messages = new MantleMessagesService($this);
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->auth->getAuthHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }

    protected function transformRequest(RequestInterface $request): RequestInterface
    {
        return $this->auth->signRequest($request);
    }
}
