<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Services\BetaService;
use Anthropic\Services\MessagesService;
use Anthropic\Services\ModelsService;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;

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

    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null
    ) {
        $this->apiKey = (string) ($apiKey ?? getenv('ANTHROPIC_API_KEY'));
        $this->authToken = (string) ($authToken ?? getenv('ANTHROPIC_AUTH_TOKEN'));

        $baseUrl ??= getenv('ANTHROPIC_BASE_URL') ?: 'https://api.anthropic.com';

        $options = RequestOptions::with(
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            transporter: Psr18ClientDiscovery::find(),
        );

        parent::__construct(
            headers: [
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            baseUrl: $baseUrl,
            options: $options,
        );

        $this->messages = new MessagesService($this);
        $this->models = new ModelsService($this);
        $this->beta = new BetaService($this);
    }

    /** @return array<string, string> */
    protected function apiKeyAuth(): array
    {
        return ['X-Api-Key' => $this->apiKey];
    }

    /** @return array<string, string> */
    protected function bearerAuth(): array
    {
        if (!$this->authToken) {
            return [];
        }

        return ['Authorization' => "Bearer {$this->authToken}"];
    }
}
