<?php

namespace Tests\Services\Beta\Messages;

use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Client;
use Anthropic\Page;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;

/**
 * @internal
 */
#[CoversNothing]
final class BatchesTest extends TestCase
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

        $result = $this->client->beta->messages->batches->create(
            requests: [
                [
                    'customID' => 'my-custom-id-1',
                    'params' => [
                        'maxTokens' => 1024,
                        'messages' => [['content' => 'Hello, world', 'role' => 'user']],
                        'model' => 'claude-sonnet-4-5-20250929',
                    ],
                ],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageBatch::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('prism validates based on the non-beta endpoint');
        }

        $result = $this->client->beta->messages->batches->create(
            requests: [
                [
                    'customID' => 'my-custom-id-1',
                    'params' => [
                        'maxTokens' => 1024,
                        'messages' => [['content' => 'Hello, world', 'role' => 'user']],
                        'model' => 'claude-sonnet-4-5-20250929',
                        'container' => [
                            'id' => 'id',
                            'skills' => [
                                ['skillID' => 'x', 'type' => 'anthropic', 'version' => 'x'],
                            ],
                        ],
                        'contextManagement' => [
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
                        'mcpServers' => [
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
                        'metadata' => ['userID' => '13803d75-b4b5-4c3e-b2a2-6f21399b021b'],
                        'outputConfig' => ['effort' => 'low'],
                        'outputFormat' => [
                            'schema' => ['foo' => 'bar'], 'type' => 'json_schema',
                        ],
                        'serviceTier' => 'auto',
                        'stopSequences' => ['string'],
                        'stream' => true,
                        'system' => [
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
                        'temperature' => 1,
                        'thinking' => ['budgetTokens' => 1024, 'type' => 'enabled'],
                        'toolChoice' => [
                            'type' => 'auto', 'disableParallelToolUse' => true,
                        ],
                        'tools' => [
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
                                'inputExamples' => [['foo' => 'bar']],
                                'strict' => true,
                                'type' => 'custom',
                            ],
                        ],
                        'topK' => 5,
                        'topP' => 0.7,
                    ],
                ],
            ],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageBatch::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->messages->batches->retrieve(
            'message_batch_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageBatch::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->messages->batches->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(MessageBatch::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->messages->batches->delete(
            'message_batch_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedMessageBatch::class, $result);
    }

    #[Test]
    public function testCancel(): void
    {
        $result = $this->client->beta->messages->batches->cancel(
            'message_batch_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageBatch::class, $result);
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism doesn\'t support application/x-jsonl responses');
        }

        $result = $this->client->beta->messages->batches->results(
            'message_batch_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MessageBatchIndividualResponse::class, $result);
    }
}
