#!/usr/bin/env php

<?php

/**
 * Structured Output: Enums, Formats, and Constraineds
 *
 * This example demonstrates advanced schema features:
 *
 * SUPPORTED by API (use #[Constrained]):
 * - description: Human-readable description
 * - format: String formats (email, uri, date-time, date, time, uuid, ipv4, ipv6, hostname)
 * - const: Fixed value
 * - minItems: Array minimum items (only 0 and 1 supported)
 *
 * Use #[Required] only when you need enum type conversion:
 * - enum: Array of allowed values (also sets up the type converter for deserialization)
 *
 * NOT SUPPORTED by API (use #[Constrained] — moved to description, validated on SDK side):
 * - minimum, maximum, multipleOf: Numerical constraints
 * - minLength, maxLength: String length constraints
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Core\Attributes\Required;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;

class ServerConfig implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(description: 'Server hostname', format: 'hostname')]
    public string $hostname;

    #[Constrained(description: 'Server IP address', format: 'ipv4')]
    public string $ip;

    #[Required(enum: ['development', 'staging', 'production'])]
    #[Constrained(description: 'Server environment')]
    public string $environment;

    #[Constrained(description: 'API endpoint', format: 'uri')]
    public string $apiEndpoint;

    // Note: minimum/maximum are NOT supported by the API.
    // They will be moved to the description and validated when parsing the response.
    #[Constrained(description: 'Server port', minimum: 1, maximum: 65535)]
    public int $port;

    #[Constrained(description: 'Config version', const: '1.0')]
    public string $version;
}

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

echo "=== Structured Output: Enums, Formats, and Constraineds ===\n\n";

$message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Generate a production server configuration for api.example.com']],
    model: 'claude-sonnet-4-5-20250929',
    outputConfig: ['format' => ServerConfig::class]
);

$config = $message->parsedOutput();

if ($config instanceof ServerConfig) {
    echo "Server Configuration:\n";
    echo "  Hostname: {$config->hostname}\n";
    echo "  IP: {$config->ip}\n";
    echo "  Environment: {$config->environment}\n";
    echo "  API Endpoint: {$config->apiEndpoint}\n";
    echo "  Port: {$config->port}\n";
    echo "  Version: {$config->version}\n";

    echo "\nSerialized back to JSON:\n";
    echo $config->toJson() . "\n";
}
