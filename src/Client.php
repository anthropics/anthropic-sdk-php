<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Services\BetaService;
use Anthropic\Services\MessagesService;
use Anthropic\Services\ModelsService;

class Client extends BaseClient
{
    public string $apiKey;

    public string $authToken;

    public MessagesService $messages;

    public ModelsService $models;

    public BetaService $beta;

    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null
    ) {
        $this->apiKey = (string) ($apiKey ?? getenv('ANTHROPIC_API_KEY'));
        $this->authToken = (string) ($authToken ?? getenv('ANTHROPIC_AUTH_TOKEN'));

        $base = $baseUrl ?? getenv(
            'ANTHROPIC_BASE_URL'
        ) ?: 'https://api.anthropic.com';

        parent::__construct(
            headers: [
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            baseUrl: $base,
            options: new RequestOptions,
        );

        $this->messages = new MessagesService($this);
        $this->models = new ModelsService($this);
        $this->beta = new BetaService($this);
    }

    /** @return array<string, string> */
    protected function authHeaders(): array
    {
        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
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
