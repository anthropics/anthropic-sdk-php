<?php

namespace Tests\Services\Beta\Messages;

use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;
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
        $result = $this->client->beta->messages->batches->create(
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

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->messages->batches->create(
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
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->messages->batches->retrieve(
            'message_batch_id'
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('skipped: currently unsupported');
        }

        $result = $this->client->beta->messages->batches->list();

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->messages->batches->delete(
            'message_batch_id'
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testCancel(): void
    {
        $result = $this->client->beta->messages->batches->cancel(
            'message_batch_id'
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support application/x-jsonl responses");
        }

        $result = $this->client->beta->messages->batches->results(
            'message_batch_id'
        );

        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }
}
