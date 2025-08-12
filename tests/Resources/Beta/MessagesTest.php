<?php

namespace Tests\Resources\Beta;

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
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Client;
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
        $params = MessageCreateParams::from(
            maxTokens: 1024,
            messages: [BetaMessageParam::from(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );
        $result = $this->client->beta->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = MessageCreateParams::from(
            maxTokens: 1024,
            messages: [BetaMessageParam::from(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
            container: 'container',
            mcpServers: [
                BetaRequestMCPServerURLDefinition::from(name: 'name', url: 'url')
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
                BetaTextBlockParam::from(text: "Today's date is 2024-06-01.")
                    ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
                    ->setCitations(
                        [
                            BetaCitationCharLocationParam::from(
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
            thinking: BetaThinkingConfigEnabled::from(budgetTokens: 1024),
            toolChoice: (new BetaToolChoiceAuto)->setDisableParallelToolUse(true),
            tools: [
                BetaTool::from(
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
        );
        $result = $this->client->beta->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $params = MessageCountTokensParams::from(
            messages: [BetaMessageParam::from(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );
        $result = $this->client->beta->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $params = MessageCountTokensParams::from(
            messages: [BetaMessageParam::from(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
            mcpServers: [
                BetaRequestMCPServerURLDefinition::from(name: 'name', url: 'url')
                    ->setAuthorizationToken('authorization_token')
                    ->setToolConfiguration(
                        (new BetaRequestMCPServerToolConfiguration)
                            ->setAllowedTools(['string'])
                            ->setEnabled(true),
                    ),
            ],
            system: [
                BetaTextBlockParam::from(text: "Today's date is 2024-06-01.")
                    ->setCacheControl((new BetaCacheControlEphemeral)->setTTL('5m'))
                    ->setCitations(
                        [
                            BetaCitationCharLocationParam::from(
                                citedText: 'cited_text',
                                documentIndex: 0,
                                documentTitle: 'x',
                                endCharIndex: 0,
                                startCharIndex: 0,
                            ),
                        ],
                    ),
            ],
            thinking: BetaThinkingConfigEnabled::from(budgetTokens: 1024),
            toolChoice: (new BetaToolChoiceAuto)->setDisableParallelToolUse(true),
            tools: [
                BetaTool::from(
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
        );
        $result = $this->client->beta->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
