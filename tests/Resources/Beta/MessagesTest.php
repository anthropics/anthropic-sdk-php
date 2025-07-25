<?php

namespace Tests\Resources\Beta;

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
use Anthropic\Parameters\Beta\MessageCountTokensParam;
use Anthropic\Parameters\Beta\MessageCreateParam;
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
            ->create(
                MessageCreateParam::new(
                    maxTokens: 1024,
                    messages: [
                        BetaMessageParam::new(content: 'Hello, world', role: 'user'),
                    ],
                    model: 'claude-sonnet-4-20250514',
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
            ->create(
                MessageCreateParam::new(
                    maxTokens: 1024,
                    messages: [
                        BetaMessageParam::new(content: 'Hello, world', role: 'user'),
                    ],
                    model: 'claude-sonnet-4-20250514',
                    container: 'container',
                    mcpServers: [
                        BetaRequestMCPServerURLDefinition::new(name: 'name', url: 'url')
                            ->setAuthorizationToken('authorization_token')
                            ->setToolConfiguration(
                                (new BetaRequestMCPServerToolConfiguration)
                                    ->setAllowedTools(['string'])
                                    ->setEnabled(true),
                            ),
                    ],
                    metadata: (new BetaMetadata)
                        ->setUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
                    serviceTier: 'auto',
                    stopSequences: ['string'],
                    system: [
                        BetaTextBlockParam::new(text: "Today's date is 2024-06-01.")
                            ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
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
                    temperature: 1,
                    thinking: BetaThinkingConfigEnabled::new(budgetTokens: 1024),
                    toolChoice: (new BetaToolChoiceAuto)->setDisableParallelToolUse(true),
                    tools: [
                        BetaTool::new(
                            inputSchema: (new InputSchema)
                                ->setProperties((object) [])
                                ->setRequired(['location']),
                            name: 'name',
                        )
                            ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
                            ->setDescription('Get the current weather in a given location')
                            ->setType('custom'),
                    ],
                    topK: 5,
                    topP: 0.7,
                    anthropicBeta: ['string'],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this
            ->client
            ->beta
            ->messages
            ->countTokens(
                MessageCountTokensParam::new(
                    messages: [BetaMessageParam::new(content: 'string', role: 'user')],
                    model: 'claude-3-7-sonnet-latest',
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->messages
            ->countTokens(
                MessageCountTokensParam::new(
                    messages: [BetaMessageParam::new(content: 'string', role: 'user')],
                    model: 'claude-3-7-sonnet-latest',
                    mcpServers: [
                        BetaRequestMCPServerURLDefinition::new(name: 'name', url: 'url')
                            ->setAuthorizationToken('authorization_token')
                            ->setToolConfiguration(
                                (new BetaRequestMCPServerToolConfiguration)
                                    ->setAllowedTools(['string'])
                                    ->setEnabled(true),
                            ),
                    ],
                    system: [
                        BetaTextBlockParam::new(text: "Today's date is 2024-06-01.")
                            ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
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
                    thinking: BetaThinkingConfigEnabled::new(budgetTokens: 1024),
                    toolChoice: (new BetaToolChoiceAuto)->setDisableParallelToolUse(true),
                    tools: [
                        BetaTool::new(
                            inputSchema: (new InputSchema)
                                ->setProperties((object) [])
                                ->setRequired(['location']),
                            name: 'name',
                        )
                            ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
                            ->setDescription('Get the current weather in a given location')
                            ->setType('custom'),
                    ],
                    anthropicBeta: ['string'],
                )
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
