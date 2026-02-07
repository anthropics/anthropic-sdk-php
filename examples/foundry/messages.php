<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Foundry;

$client = Foundry\Client::fromEnvironment(
    baseUrl: 'https://example-resource.services.ai.azure.com/anthropic'
);

// Or pass credentials explicitly.
// $client = Foundry\Client::withCredentials(
//     apiKey: 'YOUR_API_KEY',
//     baseUrl: 'https://example-resource.services.ai.azure.com/anthropic',
// );

// Or use an access token instead of an API key.
// $client = Foundry\Client::withCredentials(
//     authToken: 'YOUR_ACCESS_TOKEN',
//     baseUrl: 'https://example-resource.services.ai.azure.com/anthropic',
// );

$response = $client->messages->create(
    model: 'claude-haiku-4-5',
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
);

var_dump($response->content);
