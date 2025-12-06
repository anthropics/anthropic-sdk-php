<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageTokensCount;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class MessagesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        $result = $this->client->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Message::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
            'metadata' => ['user_id' => '13803d75-b4b5-4c3e-b2a2-6f21399b021b'],
            'service_tier' => 'auto',
            'stop_sequences' => ['string'],
            'system' => [
                [
                    'text' => 'Today\'s date is 2024-06-01.',
                    'type' => 'text',
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'citations' => [
                        [
                            'cited_text' => 'cited_text',
                            'document_index' => 0,
                            'document_title' => 'x',
                            'end_char_index' => 0,
                            'start_char_index' => 0,
                            'type' => 'char_location',
                        ],
                    ],
                ],
            ],
            'temperature' => 1,
            'thinking' => ['budget_tokens' => 1024, 'type' => 'enabled'],
            'tool_choice' => ['type' => 'auto', 'disable_parallel_tool_use' => true],
            'tools' => [
                [
                    'input_schema' => [
                        'type' => 'object',
                        'properties' => ['location' => 'bar', 'unit' => 'bar'],
                        'required' => ['location'],
                    ],
                    'name' => 'name',
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'description' => 'Get the current weather in a given location',
                    'type' => 'custom',
                ],
            ],
            'top_k' => 5,
            'top_p' => 0.7,
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Message::class, $result);
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-opus-4-5-20251101',
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageTokensCount::class, $result);
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-opus-4-5-20251101',
            'system' => [
                [
                    'text' => 'Today\'s date is 2024-06-01.',
                    'type' => 'text',
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'citations' => [
                        [
                            'cited_text' => 'cited_text',
                            'document_index' => 0,
                            'document_title' => 'x',
                            'end_char_index' => 0,
                            'start_char_index' => 0,
                            'type' => 'char_location',
                        ],
                    ],
                ],
            ],
            'thinking' => ['budget_tokens' => 1024, 'type' => 'enabled'],
            'tool_choice' => ['type' => 'auto', 'disable_parallel_tool_use' => true],
            'tools' => [
                [
                    'input_schema' => [
                        'type' => 'object',
                        'properties' => ['location' => 'bar', 'unit' => 'bar'],
                        'required' => ['location'],
                    ],
                    'name' => 'name',
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'description' => 'Get the current weather in a given location',
                    'type' => 'custom',
                ],
            ],
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageTokensCount::class, $result);
    }
}
