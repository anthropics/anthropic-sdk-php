<?php

namespace Tests\Resources\Beta\Messages;

use Anthropic\Beta\Messages\Batches\BatchCancelParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
use Anthropic\Beta\Messages\Batches\BatchDeleteParams;
use Anthropic\Beta\Messages\Batches\BatchListParams;
use Anthropic\Beta\Messages\Batches\BatchResultsParams;
use Anthropic\Beta\Messages\Batches\BatchRetrieveParams;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaCitationCharLocationParam;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaMetadata;
use Anthropic\Beta\Messages\BetaRequestMCPServerToolConfiguration;
use Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaTool\InputSchema;
use Anthropic\Beta\Messages\BetaToolChoiceAuto;
use Anthropic\Client;
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
        $params = BatchCreateParams::with(
            requests: [
                Request::with(
                    customID: 'my-custom-id-1',
                    params: Params::with(
                        maxTokens: 1024,
                        messages: [
                            BetaMessageParam::with(content: 'Hello, world', role: 'user'),
                        ],
                        model: 'claude-sonnet-4-20250514',
                    ),
                ),
            ],
        );
        $result = $this->client->beta->messages->batches->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = BatchCreateParams::with(
            requests: [
                Request::with(
                    customID: 'my-custom-id-1',
                    params: Params::with(
                        maxTokens: 1024,
                        messages: [
                            BetaMessageParam::with(content: 'Hello, world', role: 'user'),
                        ],
                        model: 'claude-sonnet-4-20250514',
                    )
                        ->withContainer('container')
                        ->withMCPServers(
                            [
                                BetaRequestMCPServerURLDefinition::with(name: 'name', url: 'url')
                                    ->withAuthorizationToken('authorization_token')
                                    ->withToolConfiguration(
                                        (new BetaRequestMCPServerToolConfiguration)
                                            ->withAllowedTools(['string'])
                                            ->withEnabled(true),
                                    ),
                            ],
                        )
                        ->withMetadata(
                            (new BetaMetadata)
                                ->withUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
                        )
                        ->withServiceTier('auto')
                        ->withStopSequences(['string'])
                        ->withStream(true)
                        ->withSystem(
                            [
                                BetaTextBlockParam::with(text: "Today's date is 2024-06-01.")
                                    ->withCacheControl(
                                        (new BetaCacheControlEphemeral)->withTTL('5m')
                                    )
                                    ->withCitations(
                                        [
                                            BetaCitationCharLocationParam::with(
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
                        ->withThinking(BetaThinkingConfigEnabled::with(budgetTokens: 1024))
                        ->withToolChoice(
                            (new BetaToolChoiceAuto)->withDisableParallelToolUse(true)
                        )
                        ->withTools(
                            [
                                BetaTool::with(
                                    inputSchema: (new InputSchema)
                                        ->withProperties((object) [])
                                        ->withRequired(['location']),
                                    name: 'name',
                                )
                                    ->withCacheControl(
                                        (new BetaCacheControlEphemeral)->withTTL('5m')
                                    )
                                    ->withDescription('Get the current weather in a given location')
                                    ->withType('custom'),
                            ],
                        )
                        ->withTopK(5)
                        ->withTopP(0.7),
                ),
            ],
            anthropicBeta: ['string'],
        );
        $result = $this->client->beta->messages->batches->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testRetrieve(): void
    {
        $params = (new BatchRetrieveParams);
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->retrieve('message_batch_id', $params)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('skipped: currently unsupported');
        }

        $params = (new BatchListParams);
        $result = $this->client->beta->messages->batches->list($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDelete(): void
    {
        $params = (new BatchDeleteParams);
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->delete('message_batch_id', $params)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCancel(): void
    {
        $params = (new BatchCancelParams);
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->cancel('message_batch_id', $params)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support application/x-jsonl responses");
        }

        $params = (new BatchResultsParams);
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->results('message_batch_id', $params)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
