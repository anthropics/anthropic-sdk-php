#!/usr/bin/env php

<?php

/**
 * Vision: Image Input
 *
 * This example demonstrates how to send images to Claude for analysis.
 * Claude can understand images sent as:
 * - Base64-encoded data (for local files)
 * - URLs (for publicly accessible images)
 *
 * Supported formats: image/jpeg, image/png, image/gif, image/webp
 *
 * Key concepts:
 * - Images are sent as content blocks within a message
 * - Multiple images can be included in a single message
 * - Images can be mixed with text content blocks
 * - Claude can compare, analyze, and describe visual content
 *
 * @see https://docs.anthropic.com/en/docs/build-with-claude/vision
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\TextBlock;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// ── Example 1: Image from URL ───────────────────────────────────

echo "=== Image from URL ===\n\n";

$response = $client->messages->create(
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => [
                [
                    'type' => 'image',
                    'source' => [
                        'type' => 'url',
                        'url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Cat03.jpg/1200px-Cat03.jpg',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => 'Describe this image in one sentence.',
                ],
            ],
        ],
    ],
    model: 'claude-sonnet-4-5-20250929',
);

foreach ($response->content as $block) {
    if ($block instanceof TextBlock) {
        echo "Claude: {$block->text}\n\n";
    }
}

// ── Example 2: Image from base64 ────────────────────────────────

echo "=== Image from Base64 ===\n\n";

// Create a minimal 1x1 red PNG for demonstration
// In a real application, you would load an actual image file:
//   $imageData = base64_encode(file_get_contents('/path/to/image.jpg'));
$imageData = base64_encode(
    "\x89PNG\r\n\x1a\n\x00\x00\x00\rIHDR\x00\x00\x00\x01"
    ."\x00\x00\x00\x01\x08\x02\x00\x00\x00\x90wS\xde\x00"
    ."\x00\x00\x0cIDATx\x9cc\xf8\x0f\x00\x00\x01\x01\x00"
    ."\x05\x18\xd8N\x00\x00\x00\x00IEND\xaeB`\x82"
);

$response = $client->messages->create(
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => [
                [
                    'type' => 'image',
                    'source' => [
                        'type' => 'base64',
                        'media_type' => 'image/png',
                        'data' => $imageData,
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => 'What do you see in this image?',
                ],
            ],
        ],
    ],
    model: 'claude-sonnet-4-5-20250929',
);

foreach ($response->content as $block) {
    if ($block instanceof TextBlock) {
        echo "Claude: {$block->text}\n\n";
    }
}

echo "[Token usage: {$response->usage->inputTokens} input, {$response->usage->outputTokens} output]\n";
