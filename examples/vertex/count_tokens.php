<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Vertex;

$client = Vertex\Client::fromEnvironment(location: 'us-east5', projectId: 'my-project-id');

$response = $client->messages->countTokens(
    model: 'claude-3-5-haiku@20241022',
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
);

var_dump($response->inputTokens);
