<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Util;
use Anthropic\Services\BetaService;
use Anthropic\Services\MessagesService;
use Anthropic\Services\ModelsService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;

/**
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $authToken;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public ModelsService $models;

    /**
     * @api
     */
    public BetaService $beta;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? getenv('ANTHROPIC_API_KEY'));
        $this->authToken = (string) ($authToken ?? getenv('ANTHROPIC_AUTH_TOKEN'));

        $baseUrl ??= Util::getenv(
            'ANTHROPIC_BASE_URL'
        ) ?: 'https://api.anthropic.com';

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
        $this->models = new ModelsService($this);
        $this->beta = new BetaService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
    }

    /** @return array<string,string> */
    protected function apiKeyAuth(): array
    {
        return $this->apiKey ? ['X-Api-Key' => $this->apiKey] : [];
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
}
