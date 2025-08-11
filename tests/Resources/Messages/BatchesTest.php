<?php

namespace Tests\Resources\Messages;

use Anthropic\Client;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\CitationCharLocationParam;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Messages\BatchCreateParams;
use Anthropic\Models\Messages\BatchCreateParams\Request;
use Anthropic\Models\Messages\BatchCreateParams\Request\Params;
use Anthropic\Models\Messages\BatchListParams;
use Anthropic\Models\Metadata;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\Tool\InputSchema;
use Anthropic\Models\ToolChoiceAuto;
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
                BatchCreateParams::new(
                    requests: [
                        Request::new(
                            customID: 'my-custom-id-1',
                            params: Params::new(
                                maxTokens: 1024,
                                messages: [
                                    MessageParam::new(content: 'Hello, world', role: 'user'),
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
                BatchCreateParams::new(
                    requests: [
                        Request::new(
                            customID: 'my-custom-id-1',
                            params: Params::new(
                                maxTokens: 1024,
                                messages: [
                                    MessageParam::new(content: 'Hello, world', role: 'user'),
                                ],
                                model: 'claude-sonnet-4-20250514',
                            )
                                ->setMetadata(
                                    (new Metadata)->setUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b')
                                )
                                ->setServiceTier('auto')
                                ->setStopSequences(['string'])
                                ->setStream(true)
                                ->setSystem(
                                    [
                                        TextBlockParam::new(text: "Today's date is 2024-06-01.")
                                            ->setCacheControl(new CacheControlEphemeral)
                                            ->setCitations(
                                                [
                                                    CitationCharLocationParam::new(
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
                                ->setTemperature(1)
                                ->setThinking(ThinkingConfigEnabled::new(budgetTokens: 1024))
                                ->setToolChoice(
                                    (new ToolChoiceAuto)->setDisableParallelToolUse(true)
                                )
                                ->setTools(
                                    [
                                        Tool::new(
                                            inputSchema: (new InputSchema)
                                                ->setProperties((object) [])
                                                ->setRequired(['location']),
                                            name: 'name',
                                        )
                                            ->setCacheControl(new CacheControlEphemeral)
                                            ->setDescription(
                                                'Get the current weather in a given location'
                                            )
                                            ->setType('custom'),
                                    ],
                                )
                                ->setTopK(5)
                                ->setTopP(0.7),
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

        $result = $this->client->messages->batches->list(new BatchListParams);

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
