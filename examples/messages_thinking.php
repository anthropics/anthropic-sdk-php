#!/usr/bin/env php

<?php

/**
 * Extended Thinking
 *
 * This example demonstrates Claude's extended thinking capability, which
 * allows the model to reason through complex problems before responding.
 *
 * Key concepts:
 * - Enable thinking with ThinkingConfigEnabled or ThinkingConfigAdaptive
 * - budget_tokens must be >= 1024 and less than max_tokens (for enabled mode)
 * - The response contains ThinkingBlock(s) with the model's reasoning
 * - Thinking blocks appear before the final text response
 * - Adaptive thinking is recommended for claude-opus-4 and lets the model
 *   decide how much thinking budget to use
 *
 * @see https://docs.claude.com/en/docs/build-with-claude/extended-thinking
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\RedactedThinkingBlock;
use Anthropic\Messages\TextBlock;
use Anthropic\Messages\ThinkingBlock;
use Anthropic\Messages\ThinkingConfigAdaptive;
use Anthropic\Messages\ThinkingConfigEnabled;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// ── Example 1: Enabled thinking with explicit budget ────────────

echo "=== Enabled Thinking (Explicit Budget) ===\n\n";

$response = $client->messages->create(
    maxTokens: 16000,
    messages: [
        [
            'role' => 'user',
            'content' => 'A farmer has a rectangular field. If he increases the length by 3 meters '
                .'and decreases the width by 2 meters, the area stays the same. If he increases the '
                .'length by 2 meters and increases the width by 3 meters, the area increases by 52 '
                .'square meters. What are the original dimensions of the field?',
        ],
    ],
    model: 'claude-sonnet-4-5-20250929',
    thinking: ThinkingConfigEnabled::with(budgetTokens: 10000),
);

// ── Process response blocks ─────────────────────────────────────

foreach ($response->content as $block) {
    if ($block instanceof ThinkingBlock) {
        echo "── Thinking ──\n";
        // Show a preview of the thinking process
        $preview = substr($block->thinking, 0, 500);
        echo $preview;
        if (strlen($block->thinking) > 500) {
            echo "\n... [" . strlen($block->thinking) . " chars total]\n";
        }
        echo "\n\n";
    }

    if ($block instanceof RedactedThinkingBlock) {
        echo "── Redacted Thinking ──\n";
        echo "[This thinking block was redacted for safety]\n\n";
    }

    if ($block instanceof TextBlock) {
        echo "── Response ──\n";
        echo $block->text . "\n\n";
    }
}

echo "[Stop reason: {$response->stopReason}]\n";
echo "[Token usage: {$response->usage->inputTokens} input, {$response->usage->outputTokens} output]\n\n";

// ── Example 2: Adaptive thinking ────────────────────────────────

echo "=== Adaptive Thinking ===\n\n";
echo "Adaptive thinking lets the model decide how much thinking budget\n";
echo "to use. Recommended for claude-opus-4 models.\n\n";

$response = $client->messages->create(
    maxTokens: 8000,
    messages: [
        [
            'role' => 'user',
            'content' => 'What is 27 * 453?',
        ],
    ],
    model: 'claude-sonnet-4-5-20250929',
    thinking: ThinkingConfigAdaptive::with(),
);

foreach ($response->content as $block) {
    if ($block instanceof ThinkingBlock) {
        echo "── Thinking ──\n";
        echo $block->thinking . "\n\n";
    }

    if ($block instanceof TextBlock) {
        echo "── Response ──\n";
        echo $block->text . "\n\n";
    }
}

echo "[Stop reason: {$response->stopReason}]\n";
echo "[Token usage: {$response->usage->inputTokens} input, {$response->usage->outputTokens} output]\n";
