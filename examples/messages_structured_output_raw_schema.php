#!/usr/bin/env php

<?php

/**
 * Structured Output: Raw JSON Schema
 *
 * This example demonstrates using a raw JSON schema for structured outputs.
 * Use this approach when you need full control over the schema format.
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\JSONOutputFormat;
use Anthropic\Messages\OutputConfig;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// Define a JSON schema directly
$schema = [
    'type' => 'object',
    'properties' => [
        'name' => ['type' => 'string', 'description' => 'The person\'s full name'],
        'age' => ['type' => 'integer', 'description' => 'Age in years'],
        'occupation' => ['type' => 'string'],
    ],
    'required' => ['name', 'age', 'occupation'],
    'additionalProperties' => false,
];

echo "=== Structured Output: Raw JSON Schema ===\n\n";

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Generate a profile for a 30-year-old software engineer named Alice.']],
    model: 'claude-sonnet-4-5-20250929',
    outputConfig: OutputConfig::with(format: JSONOutputFormat::with(schema: $schema))
);

// Raw JSON is in the text block
$textBlock = $message->content[0];
echo "Raw JSON: {$textBlock->text}\n\n";

// Parse the JSON manually if needed
$data = json_decode($textBlock->text, true);
echo "Parsed data:\n";
echo "  Name: {$data['name']}\n";
echo "  Age: {$data['age']}\n";
echo "  Occupation: {$data['occupation']}\n";
