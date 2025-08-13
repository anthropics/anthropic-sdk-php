<?php

namespace Tests\Resources\Messages;

use Anthropic\Client;
use Anthropic\Messages\Batches\BatchCreateParams;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Messages\Batches\BatchListParams;
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
        $params = BatchCreateParams::from(
            requests: [
                Request::from(
                    customID: 'my-custom-id-1',
                    params: Params::from(
                        maxTokens: 1024,
                        messages: [
                            MessageParam::from(content: 'Hello, world', role: 'user'),
                        ],
                        model: 'claude-sonnet-4-20250514',
                    ),
                ),
            ],
        );
        $result = $this->client->messages->batches->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = BatchCreateParams::from(
            requests: [
                Request::from(
                    customID: 'my-custom-id-1',
                    params: Params::from(
                        maxTokens: 1024,
                        messages: [
                            MessageParam::from(content: 'Hello, world', role: 'user'),
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
                                TextBlockParam::from(text: "Today's date is 2024-06-01.")
                                    ->setCacheControl((new CacheControlEphemeral)->setTTL('5m'))
                                    ->setCitations(
                                        [
                                            CitationCharLocationParam::from(
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
                        ->setThinking(ThinkingConfigEnabled::from(budgetTokens: 1024))
                        ->setToolChoice(
                            (new ToolChoiceAuto)->setDisableParallelToolUse(true)
                        )
                        ->setTools(
                            [
                                Tool::from(
                                    inputSchema: (new InputSchema)
                                        ->setProperties((object) [])
                                        ->setRequired(['location']),
                                    name: 'name',
                                )
                                    ->setCacheControl((new CacheControlEphemeral)->setTTL('5m'))
                                    ->setDescription('Get the current weather in a given location')
                                    ->setType('custom'),
                            ],
                        )
                        ->setTopK(5)
                        ->setTopP(0.7),
                ),
            ],
        );
        $result = $this->client->messages->batches->create($params);

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

        $params = (new BatchListParams);
        $result = $this->client->messages->batches->list($params);

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
