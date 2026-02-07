<?php

declare(strict_types=1);

namespace Anthropic\Foundry;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\Foundry\Services\MessagesService;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;

use const Anthropic\VERSION;

/**
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class Client extends BaseClient
{
    public string $apiKey;

    public ?string $authToken;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @param RequestOpts|null $requestOptions
     */
    private function __construct(
        string $baseUrl,
        string $apiKey,
        ?string $authToken,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = $apiKey;
        $this->authToken = $authToken;

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
            baseUrl: $baseUrl,
            options: $options
        );

        $this->messages = new MessagesService($this);
    }

    /**
     * Create a Foundry client using environment configuration.
     *
     * Reads the following environment variables by default:
     * - ANTHROPIC_FOUNDRY_API_KEY
     * - ANTHROPIC_FOUNDRY_BASE_URL
     * - ANTHROPIC_FOUNDRY_RESOURCE
     *
     * @param RequestOpts|null $requestOptions
     */
    public static function fromEnvironment(
        ?string $baseUrl = null,
        ?string $resource = null,
        RequestOptions|array|null $requestOptions = null,
    ): self {
        $baseUrl ??= Util::getenv('ANTHROPIC_FOUNDRY_BASE_URL');
        $resource ??= Util::getenv('ANTHROPIC_FOUNDRY_RESOURCE');
        $apiKey = Util::getenv('ANTHROPIC_FOUNDRY_API_KEY');

        return self::build(
            apiKey: $apiKey,
            authToken: null,
            baseUrl: $baseUrl,
            resource: $resource,
            requestOptions: $requestOptions,
        );
    }

    /**
     * Create a Foundry client using explicit credentials.
     *
     * @param RequestOpts|null $requestOptions
     */
    public static function withCredentials(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null,
        ?string $resource = null,
        RequestOptions|array|null $requestOptions = null,
    ): self {
        $baseUrl ??= Util::getenv('ANTHROPIC_FOUNDRY_BASE_URL');
        $resource ??= Util::getenv('ANTHROPIC_FOUNDRY_RESOURCE');

        return self::build(
            apiKey: $apiKey,
            authToken: $authToken,
            baseUrl: $baseUrl,
            resource: $resource,
            requestOptions: $requestOptions,
        );
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
    }

    /** @return array<string,string> */
    protected function apiKeyAuth(): array
    {
        return '' !== $this->apiKey ? ['x-api-key' => $this->apiKey] : [];
    }

    /** @return array<string,string> */
    protected function bearerAuth(): array
    {
        return $this->authToken ? [
            'Authorization' => "Bearer {$this->authToken}",
        ] : [];
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
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }

    /**
     * @param RequestOpts|null $requestOptions
     */
    private static function build(
        ?string $apiKey,
        ?string $authToken,
        ?string $baseUrl,
        ?string $resource,
        RequestOptions|array|null $requestOptions,
    ): self {
        $apiKey = (string) ($apiKey ?? '');
        if ('' === $authToken) {
            $authToken = null;
        }

        if (null !== $authToken && '' !== $apiKey) {
            throw new \InvalidArgumentException(
                'The `apiKey` and `authToken` arguments are mutually exclusive; only one can be passed at a time.'
            );
        }

        if ('' === $apiKey && null === $authToken) {
            throw new \InvalidArgumentException(
                'Missing credentials. Please pass one of `apiKey` or `authToken`, or set the `ANTHROPIC_FOUNDRY_API_KEY` environment variable.'
            );
        }

        $resolvedBaseUrl = self::resolveBaseUrl($baseUrl, $resource);

        return new self(
            baseUrl: self::normalizeBaseUrl($resolvedBaseUrl),
            apiKey: $apiKey,
            authToken: $authToken,
            requestOptions: $requestOptions,
        );
    }

    private static function resolveBaseUrl(?string $baseUrl, ?string $resource): string
    {
        if (null === $baseUrl || '' === $baseUrl) {
            if (null === $resource || '' === $resource) {
                throw new \InvalidArgumentException(
                    'Must provide one of the `baseUrl` or `resource` arguments, or the `ANTHROPIC_FOUNDRY_RESOURCE` environment variable.'
                );
            }

            return sprintf('https://%s.services.ai.azure.com/anthropic/', $resource);
        }

        if (null !== $resource && '' !== $resource) {
            throw new \InvalidArgumentException('The `baseUrl` and `resource` arguments are mutually exclusive.');
        }

        return $baseUrl;
    }

    private static function normalizeBaseUrl(string $baseUrl): string
    {
        $baseUrl = rtrim($baseUrl, '/');

        foreach (['/v1/messages', '/v1'] as $suffix) {
            if (str_ends_with($baseUrl, $suffix)) {
                $baseUrl = substr($baseUrl, 0, -strlen($suffix));

                break;
            }
        }

        return $baseUrl;
    }
}
