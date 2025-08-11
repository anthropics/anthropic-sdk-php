<?php

namespace Tests\Resources\Beta\Messages;

use Anthropic\Client;
use Anthropic\Models\Beta\BetaCacheControlEphemeral;
use Anthropic\Models\Beta\BetaCitationCharLocationParam;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaRequestMCPServerToolConfiguration;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaTool\InputSchema;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\Messages\BatchCancelParams;
use Anthropic\Models\Beta\Messages\BatchCreateParams;
use Anthropic\Models\Beta\Messages\BatchCreateParams\Request;
use Anthropic\Models\Beta\Messages\BatchCreateParams\Request\Params;
use Anthropic\Models\Beta\Messages\BatchDeleteParams;
use Anthropic\Models\Beta\Messages\BatchListParams;
use Anthropic\Models\Beta\Messages\BatchResultsParams;
use Anthropic\Models\Beta\Messages\BatchRetrieveParams;
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
            ->beta
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
                                    BetaMessageParam::new(content: 'Hello, world', role: 'user'),
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
            ->beta
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
                                    BetaMessageParam::new(content: 'Hello, world', role: 'user'),
                                ],
                                model: 'claude-sonnet-4-20250514',
                            )
                                ->setContainer('container')
                                ->setMCPServers(
                                    [
                                        BetaRequestMCPServerURLDefinition::new(name: 'name', url: 'url')
                                            ->setAuthorizationToken('authorization_token')
                                            ->setToolConfiguration(
                                                (new BetaRequestMCPServerToolConfiguration)
                                                    ->setAllowedTools(['string'])
                                                    ->setEnabled(true),
                                            ),
                                    ],
                                )
                                ->setMetadata(
                                    (new BetaMetadata)
                                        ->setUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
                                )
                                ->setServiceTier('auto')
                                ->setStopSequences(['string'])
                                ->setStream(true)
                                ->setSystem(
                                    [
                                        BetaTextBlockParam::new(text: "Today's date is 2024-06-01.")
                                            ->setCacheControl(
                                                (new BetaCacheControlEphemeral)->setTTL('5m')
                                            )
                                            ->setCitations(
                                                [
                                                    BetaCitationCharLocationParam::new(
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
                                ->setThinking(BetaThinkingConfigEnabled::new(budgetTokens: 1024))
                                ->setToolChoice(
                                    (new BetaToolChoiceAuto)->setDisableParallelToolUse(true)
                                )
                                ->setTools(
                                    [
                                        BetaTool::new(
                                            inputSchema: (new InputSchema)
                                                ->setProperties((object) [])
                                                ->setRequired(['location']),
                                            name: 'name',
                                        )
                                            ->setCacheControl(
                                                (new BetaCacheControlEphemeral)->setTTL('5m')
                                            )
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
                    anthropicBeta: ['string'],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->retrieve('message_batch_id', new BatchRetrieveParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('skipped: currently unsupported');
        }

        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->list(new BatchListParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->delete('message_batch_id', new BatchDeleteParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCancel(): void
    {
        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->cancel('message_batch_id', new BatchCancelParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support application/x-jsonl responses");
        }

        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->results('message_batch_id', new BatchResultsParams)
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
