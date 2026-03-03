#!/usr/bin/env php

<?php

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Lib\Tools\BetaRunnableTool;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

/**
 * A simple weather tool that can be executed client-side.
 *
 * The definition can be any client-runnable tool type (BetaTool, BetaToolBash*, etc.)
 * or a plain array. The run closure is called when the model invokes the tool.
 */
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

$runner = $client->beta->messages->toolRunner(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'What is the weather in San Francisco?']],
    model: 'claude-opus-4-6',
    tools: [$weatherTool],
);

foreach ($runner as $message) {
    echo "--- Message ---\n";
    foreach ($message->content as $block) {
        if ($block->type === 'text') {
            echo $block->text."\n";
        } elseif ($block->type === 'tool_use') {
            echo "[Tool call: {$block->name}]\n";
        }
    }
}
