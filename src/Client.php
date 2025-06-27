<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\BaseClient;
use Anthropic\Resources\Completions;
use Anthropic\Resources\Messages;
use Anthropic\Resources\Models;
use Anthropic\Resources\Beta;

class Client extends BaseClient
{
    public string $apiKey;

    public string $authToken;

    public Completions $completions;

    public Messages $messages;

    public Models $models;

    public Beta $beta;

    /**
     * @return array<string, string>
     */
    protected function authHeaders(): array
    {
        return [...$this->apiKeyAuth(), ...$this->bearerAuth()];
    }

    /**
     * @return array<string, string>
     */
    protected function apiKeyAuth(): array
    {
        return ['X-Api-Key' => $this->apiKey];
    }

    /**
     * @return array<string, string>
     */
    protected function bearerAuth(): array
    {
        if (!$this->authToken) {
            return [];
        }

        return ['Authorization' => "Bearer {$this->authToken}"];
    }

    public function __construct(
        ?string $apiKey = null,
        ?string $authToken = null,
        ?string $baseUrl = null,
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
            options: new RequestOptions(),
            baseUrl: $base,
        );

        $this->completions = new Completions($this);
        $this->messages = new Messages($this);
        $this->models = new Models($this);
        $this->beta = new Beta($this);

    }
}
