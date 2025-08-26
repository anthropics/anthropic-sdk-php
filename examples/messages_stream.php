#!/usr/bin/env php

<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\MessageParam;

$client = new Client(
    apiKey: getenv("ANTHROPIC_API_KEY") ?: "my-anthropic-api-key"
);

$stream = $client->messages->createStream(
    maxTokens: 1024,
    messages: [MessageParam::with(role: "user", content: "Hello, Claude")],
    model: "claude-sonnet-4-20250514",
);

foreach ($stream as $event) {
    var_dump($event);
}
