<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Vertex;

$client = Vertex\Client::fromEnvironment(location: 'us-east5', projectId: 'my-project-id');

$response = $client->messages->create(
    model: 'claude-sonnet-5',
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
);

var_dump($response->content);
