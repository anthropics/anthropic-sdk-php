#!/usr/bin/env php

<?php

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaTextDelta;
use Anthropic\Client;
use Anthropic\Lib\Tools\BetaRunnableTool;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$weatherTool = new BetaRunnableTool(
    definition: [
        'name' => 'get_weather',
        'description' => 'Get the current weather for a location.',
        'input_schema' => [
            'type' => 'object',
            'properties' => [
                'location' => [
                    'type' => 'string',
                    'description' => 'The city and state, e.g. San Francisco, CA',
                ],
            ],
            'required' => ['location'],
        ],
    ],
    run: function (array $input): string {
        $location = $input['location'] ?? 'unknown';

        // In a real implementation this would call a weather API
        return "The weather in {$location} is sunny with a temperature of 72°F.";
    },
);

// Creating a thread sends no request.
$thread = $client->beta->messages->thread(
    maxTokens: 1024,
    model: 'claude-opus-5-5',
    system: 'You are a friendly travel assistant. Keep your answers short.',
    tools: [$weatherTool],
);

// The first turn creates the thread on the API.
$reply = $thread->send(['role' => 'user', 'content' => 'I am planning a weekend in San Francisco.']);
foreach ($reply->content as $block) {
    if ($block instanceof BetaTextBlock) {
        echo $block->text."\n";
    }
}

// Later turns send only the new messages. Here the tool runner runs over the thread.
$thread->append(['role' => 'user', 'content' => 'What is the weather there right now?']);
foreach ($thread->toolRunner() as $message) {
    foreach ($message->content as $block) {
        if ('text' === $block->type) {
            echo $block->text."\n";
        } elseif ('tool_use' === $block->type) {
            echo "[Tool call: {$block->name}]\n";
        }
    }
}

// A turn can be streamed.
foreach ($thread->sendStream(['role' => 'user', 'content' => 'What should I pack?']) as $event) {
    if ($event instanceof BetaRawContentBlockDeltaEvent && $event->delta instanceof BetaTextDelta) {
        echo $event->delta->text;
    }
}
echo "\n";

printf("The thread holds %d messages and continues from %s.\n", count($thread->messages()), $thread->previousMessageId());
