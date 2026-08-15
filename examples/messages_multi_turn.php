#!/usr/bin/env php

<?php

/**
 * Multi-Turn Conversation
 *
 * This example demonstrates how to maintain a multi-turn conversation
 * with Claude by accumulating messages in a history array.
 *
 * Key concepts:
 * - Messages alternate between 'user' and 'assistant' roles
 * - The full conversation history is sent with each request
 * - Claude uses the entire history for context when generating responses
 * - System prompts can set persistent behavior across all turns
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\TextBlock;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// ── System prompt for persistent instructions ───────────────────

$system = 'You are a helpful math tutor. When solving problems, show your work step-by-step. Be concise but thorough.';

// ── Simulated conversation turns ────────────────────────────────

$userTurns = [
    'What is the derivative of x^3 + 2x^2 - 5x + 3?',
    'Now find the second derivative.',
    'At what values of x is the original function concave up?',
];

$messages = [];

foreach ($userTurns as $turn) {
    echo "User: {$turn}\n\n";

    // Add the user message to history
    $messages[] = ['role' => 'user', 'content' => $turn];

    // Send the full conversation history
    $response = $client->messages->create(
        maxTokens: 1024,
        messages: $messages,
        model: 'claude-sonnet-4-5-20250929',
        system: $system,
    );

    // Extract the text response
    $assistantText = '';
    foreach ($response->content as $block) {
        if ($block instanceof TextBlock) {
            $assistantText .= $block->text;
        }
    }

    echo "Claude: {$assistantText}\n";
    echo str_repeat('─', 60) . "\n\n";

    // Add the assistant response to history for the next turn
    $messages[] = ['role' => 'assistant', 'content' => $assistantText];
}

echo "[Conversation completed: " . count($messages) . " messages]\n";
echo "[Final token usage: {$response->usage->inputTokens} input, {$response->usage->outputTokens} output]\n";
