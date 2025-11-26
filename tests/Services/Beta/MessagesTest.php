<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Client;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessage::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->create([
            'max_tokens' => 1024,
            'messages' => [['content' => 'Hello, world', 'role' => 'user']],
            'model' => 'claude-sonnet-4-5-20250929',
            'container' => [
                'id' => 'id',
                'skills' => [
                    ['skill_id' => 'x', 'type' => 'anthropic', 'version' => 'x'],
                ],
            ],
            'context_management' => [
                'edits' => [
                    [
                        'type' => 'clear_tool_uses_20250919',
                        'clear_at_least' => ['type' => 'input_tokens', 'value' => 0],
                        'clear_tool_inputs' => true,
                        'exclude_tools' => ['string'],
                        'keep' => ['type' => 'tool_uses', 'value' => 0],
                        'trigger' => ['type' => 'input_tokens', 'value' => 1],
                    ],
                ],
            ],
            'mcp_servers' => [
                [
                    'name' => 'name',
                    'type' => 'url',
                    'url' => 'url',
                    'authorization_token' => 'authorization_token',
                    'tool_configuration' => [
                        'allowed_tools' => ['string'], 'enabled' => true,
                    ],
                ],
            ],
            'metadata' => ['user_id' => '13803d75-b4b5-4c3e-b2a2-6f21399b021b'],
            'output_config' => ['effort' => 'low'],
            'output_format' => [
                'schema' => ['foo' => 'bar'], 'type' => 'json_schema',
            ],
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
                    'allowed_callers' => ['direct'],
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'defer_loading' => true,
                    'description' => 'Get the current weather in a given location',
                    'input_examples' => [['foo' => 'bar']],
                    'strict' => true,
                    'type' => 'custom',
                ],
            ],
            'top_k' => 5,
            'top_p' => 0.7,
            'betas' => ['string'],
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessage::class, $result);
    }

    #[Test]
    public function testCountTokens(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-opus-4-5-20251101',
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessageTokensCount::class, $result);
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->countTokens([
            'messages' => [['content' => 'string', 'role' => 'user']],
            'model' => 'claude-opus-4-5-20251101',
            'context_management' => [
                'edits' => [
                    [
                        'type' => 'clear_tool_uses_20250919',
                        'clear_at_least' => ['type' => 'input_tokens', 'value' => 0],
                        'clear_tool_inputs' => true,
                        'exclude_tools' => ['string'],
                        'keep' => ['type' => 'tool_uses', 'value' => 0],
                        'trigger' => ['type' => 'input_tokens', 'value' => 1],
                    ],
                ],
            ],
            'mcp_servers' => [
                [
                    'name' => 'name',
                    'type' => 'url',
                    'url' => 'url',
                    'authorization_token' => 'authorization_token',
                    'tool_configuration' => [
                        'allowed_tools' => ['string'], 'enabled' => true,
                    ],
                ],
            ],
            'output_config' => ['effort' => 'low'],
            'output_format' => [
                'schema' => ['foo' => 'bar'], 'type' => 'json_schema',
            ],
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
                    'allowed_callers' => ['direct'],
                    'cache_control' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'defer_loading' => true,
                    'description' => 'Get the current weather in a given location',
                    'input_examples' => [['foo' => 'bar']],
                    'strict' => true,
                    'type' => 'custom',
                ],
            ],
            'betas' => ['string'],
        ]);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessageTokensCount::class, $result);
    }
}
