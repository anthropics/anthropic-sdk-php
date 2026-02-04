<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Bedrock;

// Discover and create a Bedrock client from the current environment (e.g. Environment variables, EC2 instance profile)
$client = Bedrock\Client::fromEnvironment();

// Explicit credentials and region
// $client = Bedrock\Client::withCredentials(
//     accessKeyId: 'YOUR_ACCESS_KEY_ID',
//     secretAccessKey: 'YOUR_AWS_SECRET',
//     region: 'us-east-1',
// );

$response = $client->messages->create(
    model: 'anthropic.claude-3-haiku-20240307-v1:0',
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
);

var_dump($response->content);

