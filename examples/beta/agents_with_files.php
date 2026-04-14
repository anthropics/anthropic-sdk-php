#!/usr/bin/env php

<?php

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Core\FileParam;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// Create an environment
$environment = $client->beta->environments->create(
    name: 'files-example-environment'
);
echo "Created environment: {$environment->id}\n";

// Create an agent
$agent = $client->beta->agents->create(
    name: 'files-example-agent',
    model: 'claude-sonnet-4-6',
    tools: [
        [
            'type' => 'agent_toolset_20260401',
            'default_config' => [
                'enabled' => true,
                'permission_policy' => ['type' => 'always_allow'],
            ],
        ],
    ],
);
echo "Created agent: {$agent->id}\n";

// Upload a file to the Files API
$fileContents = file_get_contents(__DIR__.'/data.csv');
$file = $client->beta->files->upload(file: FileParam::fromString($fileContents, 'data.csv', 'text/csv'));
echo "Uploaded file: {$file->id}\n";

// List files to confirm upload
$filesList = $client->beta->files->list();
echo 'Listed files: ['.implode(', ', array_map(fn ($f) => $f->id, $filesList->getItems()))."]\n";

// Create a session with the file mounted as a resource
$session = $client->beta->sessions->create(
    agent: ['type' => 'agent', 'id' => $agent->id, 'version' => $agent->version],
    environmentID: $environment->id,
    resources: [
        [
            'type' => 'file',
            'file_id' => $file->id,
            'mount_path' => 'data.csv',
        ],
    ]
);
echo "Created session: {$session->id}\n";

// Send a user message asking about the file
$client->beta->sessions->events->send(
    sessionID: $session->id,
    events: [
        [
            'type' => 'user.message',
            'content' => [['type' => 'text', 'text' => 'What products are in the data.csv file? Summarize the data briefly.']],
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

// Clean up the uploaded file
$client->beta->files->delete($file->id);
echo "Deleted file: {$file->id}\n";
