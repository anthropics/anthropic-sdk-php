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
    model: 'anthropic.claude-sonnet-4-20250514-v1:0',
);

var_dump($response->inputTokens);
