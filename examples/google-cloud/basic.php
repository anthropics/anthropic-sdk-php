<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\GoogleCloud;
use Anthropic\Messages\Model;

// Reads ANTHROPIC_GOOGLE_CLOUD_PROJECT, ANTHROPIC_GOOGLE_CLOUD_LOCATION,
// and ANTHROPIC_GOOGLE_CLOUD_WORKSPACE_ID from the environment, and
// authenticates via Google Application Default Credentials.
$client = new GoogleCloud\Client;

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Hello, Claude!']],
    model: Model::CLAUDE_HAIKU_4_5,
);

var_dump($message->content);
