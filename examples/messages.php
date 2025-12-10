#!/usr/bin/env php

<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Hello, Claude']],
    model: 'claude-sonnet-4-20250514'
);

var_dump($message->content);
