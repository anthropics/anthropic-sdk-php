#!/usr/bin/env php

<?php

/**
 * Tool Use: Agentic Loop
 *
 * This example demonstrates the complete tool use flow with the Messages API:
 * 1. Define tools with JSON schema for input validation
 * 2. Send a request that may trigger tool use
 * 3. Detect tool_use blocks in the response
 * 4. Execute the tool locally and return tool_result
 * 5. Continue the conversation until the model produces a final answer
 *
 * This pattern is the foundation for building AI agents that can
 * interact with external systems (APIs, databases, file systems, etc.).
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\TextBlock;
use Anthropic\Messages\ToolUseBlock;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// ── Define tools ────────────────────────────────────────────────

$tools = [
    [
        'name' => 'get_weather',
        'description' => 'Get the current weather in a given location. Returns temperature in Fahrenheit and a brief description of conditions.',
        'input_schema' => [
            'type' => 'object',
            'properties' => [
                'location' => [
                    'type' => 'string',
                    'description' => 'The city and state, e.g. "San Francisco, CA"',
                ],
                'unit' => [
                    'type' => 'string',
                    'enum' => ['celsius', 'fahrenheit'],
                    'description' => 'Temperature unit (defaults to fahrenheit)',
                ],
            ],
            'required' => ['location'],
        ],
    ],
    [
        'name' => 'get_time',
        'description' => 'Get the current time in a given timezone.',
        'input_schema' => [
            'type' => 'object',
            'properties' => [
                'timezone' => [
                    'type' => 'string',
                    'description' => 'The IANA timezone name, e.g. "America/New_York"',
                ],
            ],
            'required' => ['timezone'],
        ],
    ],
];

// ── Simulate tool execution ─────────────────────────────────────

/**
 * Process a tool call and return the result string.
 *
 * In a real application, these would call actual APIs or services.
 */
function executeTool(string $name, array $input): string
{
    return match ($name) {
        'get_weather' => json_encode([
            'location' => $input['location'],
            'temperature' => 72,
            'unit' => $input['unit'] ?? 'fahrenheit',
            'conditions' => 'Sunny with light clouds',
            'humidity' => '45%',
        ]),
        'get_time' => json_encode([
            'timezone' => $input['timezone'],
            'time' => '2025-03-25T14:30:00',
            'day_of_week' => 'Tuesday',
        ]),
        default => json_encode(['error' => "Unknown tool: {$name}"]),
    };
}

// ── Agentic loop ────────────────────────────────────────────────

$messages = [
    ['role' => 'user', 'content' => 'What\'s the weather like in San Francisco and what time is it in New York?'],
];

echo "User: {$messages[0]['content']}\n\n";

// The model may need multiple turns to call all necessary tools
while (true) {
    $response = $client->messages->create(
        maxTokens: 1024,
        messages: $messages,
        model: 'claude-sonnet-4-5-20250929',
        tools: $tools,
    );

    // Collect tool results from this turn
    $toolResults = [];

    foreach ($response->content as $block) {
        if ($block instanceof TextBlock) {
            echo "Claude: {$block->text}\n";
        }

        if ($block instanceof ToolUseBlock) {
            echo "[Tool call: {$block->name}(" . json_encode($block->input) . ")]\n";

            // Execute the tool and collect the result
            $result = executeTool($block->name, $block->input);
            echo "[Tool result: {$result}]\n\n";

            $toolResults[] = [
                'type' => 'tool_result',
                'tool_use_id' => $block->id,
                'content' => $result,
            ];
        }
    }

    // If the model stopped for tool use, feed results back and continue
    if ($response->stopReason === 'tool_use') {
        // Add the assistant's response (with tool_use blocks) to history
        $messages[] = ['role' => 'assistant', 'content' => $response->content];
        // Add all tool results in a single user message
        $messages[] = ['role' => 'user', 'content' => $toolResults];

        continue;
    }

    // Model produced a final answer — we're done
    break;
}

echo "\n[Stop reason: {$response->stopReason}]\n";
echo "[Token usage: {$response->usage->inputTokens} input, {$response->usage->outputTokens} output]\n";
