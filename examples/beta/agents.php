#!/usr/bin/env php

<?php

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Client;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// Create an environment
$environment = $client->beta->environments->create(
    name: 'simple-example-environment'
);
echo "Created environment: {$environment->id}\n";

// Create an agent
$agent = $client->beta->agents->create(
    name: 'simple-example-agent',
    model: 'claude-sonnet-4-6'
);
echo "Created agent: {$agent->id}\n";

// Create a session pinned to the agent version
$session = $client->beta->sessions->create(
    agent: ['type' => 'agent', 'id' => $agent->id, 'version' => $agent->version],
    environmentID: $environment->id
);
echo "Created session: {$session->id}\n";

// Send a user message
$client->beta->sessions->events->send(
    sessionID: $session->id,
    events: [
        [
            'type' => 'user.message',
            'content' => [['type' => 'text', 'text' => 'Hello Claude!']],
        ],
    ]
);

// Stream events until the session goes idle
echo "Streaming events:\n";
$stream = $client->beta->sessions->events->streamStream(sessionID: $session->id);
foreach ($stream as $event) {
    echo json_encode($event, JSON_PRETTY_PRINT)."\n";
    if ($event->type === 'session.status_idle') {
        break;
    }
}
