<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Bedrock;

// Discover and create a Bedrock client from the current environment (e.g. Environment variables, EC2 instance profile)
$client = Bedrock\Client::fromEnvironment();

$response = $client->messages->countTokens(
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
    model: 'global.anthropic.claude-sonnet-5',
);

var_dump($response->inputTokens);
