<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Foundry;

$client = Foundry\Client::fromEnvironment(
    baseUrl: 'https://example-resource.services.ai.azure.com/anthropic'
);

$response = $client->messages->countTokens(
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
    model: 'claude-haiku-4-5',
);

var_dump($response->inputTokens);
