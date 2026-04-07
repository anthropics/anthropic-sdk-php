<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Client;
use Anthropic\Core\Util;
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

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        $result = $this->client->beta->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello, world', 'role' => 'user']],
            model: 'claude-opus-4-6',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessage::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello, world', 'role' => 'user']],
            model: 'claude-opus-4-6',
            cacheControl: ['type' => 'ephemeral', 'ttl' => '5m'],
            container: [
                'id' => 'id',
                'skills' => [
                    ['skillID' => 'pdf', 'type' => 'anthropic', 'version' => 'latest'],
                ],
            ],
            contextManagement: [
                'edits' => [
                    [
                        'type' => 'clear_tool_uses_20250919',
                        'clearAtLeast' => ['type' => 'input_tokens', 'value' => 0],
                        'clearToolInputs' => true,
                        'excludeTools' => ['string'],
                        'keep' => ['type' => 'tool_uses', 'value' => 0],
                        'trigger' => ['type' => 'input_tokens', 'value' => 1],
                    ],
                ],
            ],
            inferenceGeo: 'inference_geo',
            mcpServers: [
                [
                    'name' => 'name',
                    'type' => 'url',
                    'url' => 'url',
                    'authorizationToken' => 'authorization_token',
                    'toolConfiguration' => [
                        'allowedTools' => ['string'], 'enabled' => true,
                    ],
                ],
            ],
            metadata: ['userID' => '13803d75-b4b5-4c3e-b2a2-6f21399b021b'],
            outputConfig: [
                'effort' => 'low',
                'format' => ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            ],
            outputFormat: ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            serviceTier: 'auto',
            speed: 'standard',
            stopSequences: ['string'],
            system: [
                [
                    'text' => 'Today\'s date is 2024-06-01.',
                    'type' => 'text',
                    'cacheControl' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'citations' => [
                        [
                            'citedText' => 'cited_text',
                            'documentIndex' => 0,
                            'documentTitle' => 'x',
                            'endCharIndex' => 0,
                            'startCharIndex' => 0,
                            'type' => 'char_location',
                        ],
                    ],
                ],
            ],
            temperature: 1,
            thinking: ['type' => 'adaptive', 'display' => 'summarized'],
            toolChoice: ['type' => 'auto', 'disableParallelToolUse' => true],
            tools: [
                [
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => ['location' => 'bar', 'unit' => 'bar'],
                        'required' => ['location'],
                    ],
                    'name' => 'name',
                    'allowedCallers' => ['direct'],
                    'cacheControl' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'deferLoading' => true,
                    'description' => 'Get the current weather in a given location',
                    'eagerInputStreaming' => true,
                    'inputExamples' => [['foo' => 'bar']],
                    'strict' => true,
                    'type' => 'custom',
                ],
            ],
            topK: 5,
            topP: 0.7,
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessage::class, $result);
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->beta->messages->countTokens(
            messages: [['content' => 'string', 'role' => 'user']],
            model: 'claude-mythos-preview',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessageTokensCount::class, $result);
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->beta->messages->countTokens(
            messages: [['content' => 'string', 'role' => 'user']],
            model: 'claude-mythos-preview',
            cacheControl: ['type' => 'ephemeral', 'ttl' => '5m'],
            contextManagement: [
                'edits' => [
                    [
                        'type' => 'clear_tool_uses_20250919',
                        'clearAtLeast' => ['type' => 'input_tokens', 'value' => 0],
                        'clearToolInputs' => true,
                        'excludeTools' => ['string'],
                        'keep' => ['type' => 'tool_uses', 'value' => 0],
                        'trigger' => ['type' => 'input_tokens', 'value' => 1],
                    ],
                ],
            ],
            mcpServers: [
                [
                    'name' => 'name',
                    'type' => 'url',
                    'url' => 'url',
                    'authorizationToken' => 'authorization_token',
                    'toolConfiguration' => [
                        'allowedTools' => ['string'], 'enabled' => true,
                    ],
                ],
            ],
            outputConfig: [
                'effort' => 'low',
                'format' => ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            ],
            outputFormat: ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            speed: 'standard',
            system: [
                [
                    'text' => 'Today\'s date is 2024-06-01.',
                    'type' => 'text',
                    'cacheControl' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'citations' => [
                        [
                            'citedText' => 'cited_text',
                            'documentIndex' => 0,
                            'documentTitle' => 'x',
                            'endCharIndex' => 0,
                            'startCharIndex' => 0,
                            'type' => 'char_location',
                        ],
                    ],
                ],
            ],
            thinking: ['type' => 'adaptive', 'display' => 'summarized'],
            toolChoice: ['type' => 'auto', 'disableParallelToolUse' => true],
            tools: [
                [
                    'inputSchema' => [
                        'type' => 'object',
                        'properties' => ['location' => 'bar', 'unit' => 'bar'],
                        'required' => ['location'],
                    ],
                    'name' => 'name',
                    'allowedCallers' => ['direct'],
                    'cacheControl' => ['type' => 'ephemeral', 'ttl' => '5m'],
                    'deferLoading' => true,
                    'description' => 'Get the current weather in a given location',
                    'eagerInputStreaming' => true,
                    'inputExamples' => [['foo' => 'bar']],
                    'strict' => true,
                    'type' => 'custom',
                ],
            ],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaMessageTokensCount::class, $result);
    }
}
