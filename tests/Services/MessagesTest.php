<?php

namespace Tests\Services;

use Anthropic\Client;
use Anthropic\Core\Util;
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

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        $result = $this->client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello, world', 'role' => 'user']],
            model: 'claude-opus-4-6',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Message::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->messages->create(
            maxTokens: 1024,
            messages: [['content' => 'Hello, world', 'role' => 'user']],
            model: 'claude-opus-4-6',
            container: 'container',
            inferenceGeo: 'inference_geo',
            metadata: ['userID' => '13803d75-b4b5-4c3e-b2a2-6f21399b021b'],
            outputConfig: [
                'effort' => 'low',
                'format' => ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            ],
            serviceTier: 'auto',
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
            thinking: ['budgetTokens' => 1024, 'type' => 'enabled'],
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
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Message::class, $result);
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->messages->countTokens(
            messages: [['content' => 'string', 'role' => 'user']],
            model: 'claude-opus-4-6',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageTokensCount::class, $result);
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->messages->countTokens(
            messages: [['content' => 'string', 'role' => 'user']],
            model: 'claude-opus-4-6',
            outputConfig: [
                'effort' => 'low',
                'format' => ['schema' => ['foo' => 'bar'], 'type' => 'json_schema'],
            ],
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
            thinking: ['budgetTokens' => 1024, 'type' => 'enabled'],
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
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageTokensCount::class, $result);
    }
}
