<?php

namespace Tests\Resources\Messages;

use Anthropic\Client;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\CitationCharLocationParam;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\Tool\InputSchema;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Parameters\Messages\BatchCreateParam;
use Anthropic\Parameters\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Messages\BatchCreateParam\Request\Params;
use Anthropic\Parameters\Messages\BatchListParam;
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
        $result = $this
            ->client
            ->messages
            ->batches
            ->create(
                new BatchCreateParam(
                    requests: [
                        new Request(
                            customID: 'my-custom-id-1',
                            params: new Params(
                                maxTokens: 1024,
                                messages: [
                                    new MessageParam(content: 'Hello, world', role: 'user'),
                                ],
                                model: 'claude-sonnet-4-20250514',
                            ),
                        ),
                    ],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->messages
            ->batches
            ->create(
                new BatchCreateParam(
                    requests: [
                        new Request(
                            customID: 'my-custom-id-1',
                            params: new Params(
                                maxTokens: 1024,
                                messages: [
                                    new MessageParam(content: 'Hello, world', role: 'user'),
                                ],
                                model: 'claude-sonnet-4-20250514',
                                metadata: new Metadata(
                                    userID: '13803d75-b4b5-4c3e-b2a2-6f21399b021b'
                                ),
                                serviceTier: 'auto',
                                stopSequences: ['string'],
                                stream: true,
                                system: [
                                    new TextBlockParam(
                                        text: "Today's date is 2024-06-01.",
                                        cacheControl: new CacheControlEphemeral(),
                                        citations: [
                                            new CitationCharLocationParam(
                                                citedText: 'cited_text',
                                                documentIndex: 0,
                                                documentTitle: 'x',
                                                endCharIndex: 0,
                                                startCharIndex: 0,
                                            ),
                                        ],
                                    ),
                                ],
                                temperature: 1,
                                thinking: new ThinkingConfigEnabled(budgetTokens: 1024),
                                toolChoice: new ToolChoiceAuto(disableParallelToolUse: true),
                                tools: [
                                    new Tool(
                                        inputSchema: new InputSchema(
                                            properties: [
                                                'location' => [
                                                    'description' => 'The city and state, e.g. San Francisco, CA',
                                                    'type' => 'string',
                                                ],
                                                'unit' => [
                                                    'description' => 'Unit for the output - one of (celsius, fahrenheit)',
                                                    'type' => 'string',
                                                ],
                                            ],
                                            required: ['location'],
                                        ),
                                        name: 'name',
                                        cacheControl: new CacheControlEphemeral(),
                                        description: 'Get the current weather in a given location',
                                        type: 'custom',
                                    ),
                                ],
                                topK: 5,
                                topP: 0.7,
                            ),
                        ),
                    ],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->messages->batches->retrieve('message_batch_id');

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('skipped: currently unsupported');
        }

        $result = $this->client->messages->batches->list(new BatchListParam());

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->messages->batches->delete('message_batch_id');

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCancel(): void
    {
        $result = $this->client->messages->batches->cancel('message_batch_id');

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support JSONL responses yet");
        }

        $result = $this->client->messages->batches->results('message_batch_id');

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
