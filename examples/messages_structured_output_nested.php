#!/usr/bin/env php

<?php

/**
 * Structured Output: Nested Models and Arrays
 *
 * This example demonstrates using nested models and arrays of models.
 * - Nested objects are auto-detected from PHP type hints
 * - Arrays of models require the itemClass parameter in #[Required]
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Core\Attributes\Required;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;

// Define nested models
class Address implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public string $street;
    public string $city;
    public string $country;
}

class ContactInfo implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(description: 'Primary email address', format: 'email')]
    public string $email;

    public ?string $phone = null;

    public Address $address;  // Nested model - auto-detected from type hint!
}

class Skill implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public string $name;

    #[Required(enum: ['beginner', 'intermediate', 'expert'])]
    #[Constrained(description: 'Proficiency level')]
    public string $level;
}

// Main model with nested objects and arrays
class Employee implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public string $name;
    public string $title;
    public ContactInfo $contact;  // Nested model

    #[Constrained(description: 'List of skills', itemClass: Skill::class, minItems: 1)]
    public array $skills;  // Array of models - requires itemClass
}

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

echo "=== Structured Output: Nested Models and Arrays ===\n\n";

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Create an employee profile for a senior developer named Carol in San Francisco with 3 programming skills.']],
    model: 'claude-sonnet-4-5-20250929',
    outputConfig: ['format' => Employee::class]
);

$employee = $message->parsedOutput();

if ($employee instanceof Employee) {
    echo "Name: {$employee->name}\n";
    echo "Title: {$employee->title}\n";
    echo "\nContact Info:\n";
    echo "  Email: {$employee->contact->email}\n";
    echo "  Phone: " . ($employee->contact->phone ?? 'Not provided') . "\n";
    echo "  Address: {$employee->contact->address->street}\n";
    echo "           {$employee->contact->address->city}, {$employee->contact->address->country}\n";

    echo "\nSkills:\n";
    foreach ($employee->skills as $skill) {
        echo "  - {$skill->name} ({$skill->level})\n";
    }

    // The entire nested structure can be serialized back to JSON
    echo "\nSerialized back to JSON:\n";
    echo $employee->toJson() . "\n";
}
