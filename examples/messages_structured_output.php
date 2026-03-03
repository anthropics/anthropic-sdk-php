#!/usr/bin/env php

<?php

/**
 * Structured Output: Type Inference
 *
 * This example demonstrates using structured output model classes.
 * The SDK automatically infers JSON schema from PHP type hints:
 * - string, int, float, bool -> corresponding JSON types
 * - ?type (nullable) -> optional field
 * - No #[Required] needed for basic fields!
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;

// Define a model class - types are automatically inferred
class Person implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(description: 'The person\'s full name')]
    public string $name;

    #[Constrained(description: 'Age in years')]
    public int $age;

    public string $occupation;  // No attribute needed - type is inferred!

    public ?string $email = null;  // Nullable = optional field
}

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

echo "=== Structured Output: Type Inference ===\n\n";

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Generate a profile for a 28-year-old data scientist named Bob with email bob@example.com.']],
    model: 'claude-sonnet-4-5-20250929',
    outputConfig: ['format' => Person::class]  // Pass the class directly!
);

// Get the parsed output as a Person instance
$person = $message->parsedOutput();

if ($person instanceof Person) {
    echo "Name: {$person->name}\n";
    echo "Age: {$person->age}\n";
    echo "Occupation: {$person->occupation}\n";
    echo "Email: " . ($person->email ?? 'Not provided') . "\n";

    // The model can be serialized back to JSON
    echo "\nSerialized back to JSON:\n";
    echo $person->toJson() . "\n";
}
