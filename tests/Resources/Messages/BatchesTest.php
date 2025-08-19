<?php

namespace Tests\Resources\Messages;

use Anthropic\Client;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Messages\CacheControlEphemeral;
use Anthropic\Messages\CitationCharLocationParam;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ThinkingConfigEnabled;
use Anthropic\Messages\Tool;
use Anthropic\Messages\Tool\InputSchema;
use Anthropic\Messages\ToolChoiceAuto;
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
        $result = $this->client->messages->batches->create(
            [
                Request::with(
                    customID: 'my-custom-id-1',
                    params: Params::with(
                        maxTokens: 1024,
                        messages: [
                            MessageParam::with(content: 'Hello, world', role: 'user'),
                        ],
                        model: 'claude-sonnet-4-20250514',
                    ),
                ),
            ],
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->messages->batches->create(
            [
                Request::with(
                    customID: 'my-custom-id-1',
                    params: Params::with(
                        maxTokens: 1024,
                        messages: [
                            MessageParam::with(content: 'Hello, world', role: 'user'),
                        ],
                        model: 'claude-sonnet-4-20250514',
                    )
                        ->withMetadata(
                            (new Metadata)->withUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b')
                        )
                        ->withServiceTier('auto')
                        ->withStopSequences(['string'])
                        ->withStream(true)
                        ->withSystem(
                            [
                                TextBlockParam::with(text: "Today's date is 2024-06-01.")
                                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                                    ->withCitations(
                                        [
                                            CitationCharLocationParam::with(
                                                citedText: 'cited_text',
                                                documentIndex: 0,
                                                documentTitle: 'x',
                                                endCharIndex: 0,
                                                startCharIndex: 0,
                                            ),
                                        ],
                                    ),
                            ],
                        )
                        ->withTemperature(1)
                        ->withThinking(ThinkingConfigEnabled::with(budgetTokens: 1024))
                        ->withToolChoice(
                            (new ToolChoiceAuto)->withDisableParallelToolUse(true)
                        )
                        ->withTools(
                            [
                                Tool::with(
                                    inputSchema: (new InputSchema)
                                        ->withProperties(
                                            [
                                                'location' => [
                                                    'description' => 'The city and state, e.g. San Francisco, CA',
                                                    'type' => 'string',
                                                ],
                                                'unit' => [
                                                    'description' => 'Unit for the output - one of (celsius, fahrenheit)',
                                                    'type' => 'string',
                                                ],
                                            ],
                                        )
                                        ->withRequired(['location']),
                                    name: 'name',
                                )
                                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                                    ->withDescription('Get the current weather in a given location')
                                    ->withType('custom'),
                            ],
                        )
                        ->withTopK(5)
                        ->withTopP(0.7),
                ),
            ],
        );

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

        $result = $this->client->messages->batches->list();

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
            $this->markTestSkipped("Prism doesn't support application/x-jsonl responses");
        }

        $result = $this->client->messages->batches->results('message_batch_id');

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
