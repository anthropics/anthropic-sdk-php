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
use Anthropic\Parameters\Beta\Messages\BatchCancelParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request\Params;
use Anthropic\Parameters\Beta\Messages\BatchDeleteParam;
use Anthropic\Parameters\Beta\Messages\BatchListParam;
use Anthropic\Parameters\Beta\Messages\BatchResultsParam;
use Anthropic\Parameters\Beta\Messages\BatchRetrieveParam;
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
                new BatchCreateParam(
                    requests: [
                        new Request(
                            customID: 'my-custom-id-1',
                            params: new Params(
                                maxTokens: 1024,
                                messages: [
                                    new BetaMessageParam(content: 'Hello, world', role: 'user'),
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
                new BatchCreateParam(
                    requests: [
                        new Request(
                            customID: 'my-custom-id-1',
                            params: new Params(
                                maxTokens: 1024,
                                messages: [
                                    new BetaMessageParam(content: 'Hello, world', role: 'user'),
                                ],
                                model: 'claude-sonnet-4-20250514',
                                container: 'container',
                                mcpServers: [
                                    new BetaRequestMCPServerURLDefinition(
                                        name: 'name',
                                        url: 'url',
                                        authorizationToken: 'authorization_token',
                                        toolConfiguration: new BetaRequestMCPServerToolConfiguration(
                                            allowedTools: ['string'],
                                            enabled: true
                                        ),
                                    ),
                                ],
                                metadata: new BetaMetadata(
                                    userID: '13803d75-b4b5-4c3e-b2a2-6f21399b021b'
                                ),
                                serviceTier: 'auto',
                                stopSequences: ['string'],
                                stream: true,
                                system: [
                                    new BetaTextBlockParam(
                                        text: "Today's date is 2024-06-01.",
                                        cacheControl: new BetaCacheControlEphemeral(ttl: '5m'),
                                        citations: [
                                            new BetaCitationCharLocationParam(
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
                                thinking: new BetaThinkingConfigEnabled(budgetTokens: 1024),
                                toolChoice: new BetaToolChoiceAuto(disableParallelToolUse: true),
                                tools: [
                                    new BetaTool(
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
                                        cacheControl: new BetaCacheControlEphemeral(ttl: '5m'),
                                        description: 'Get the current weather in a given location',
                                        type: 'custom',
                                    ),
                                ],
                                topK: 5,
                                topP: 0.7,
                            ),
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
            ->retrieve('message_batch_id', new BatchRetrieveParam())
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
            ->list(new BatchListParam())
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
            ->delete('message_batch_id', new BatchDeleteParam())
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
            ->cancel('message_batch_id', new BatchCancelParam())
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped("Prism doesn't support JSONL responses yet");
        }

        $result = $this
            ->client
            ->beta
            ->messages
            ->batches
            ->results('message_batch_id', new BatchResultsParam())
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
