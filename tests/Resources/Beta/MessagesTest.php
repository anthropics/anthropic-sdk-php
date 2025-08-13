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
        $params = MessageCreateParams::with(
            maxTokens: 1024,
            messages: [BetaMessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );
        $result = $this->client->beta->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = MessageCreateParams::with(
            maxTokens: 1024,
            messages: [BetaMessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
            container: 'container',
            mcpServers: [
                BetaRequestMCPServerURLDefinition::with(name: 'name', url: 'url')
                    ->withAuthorizationToken('authorization_token')
                    ->withToolConfiguration(
                        (new BetaRequestMCPServerToolConfiguration)
                            ->withAllowedTools(['string'])
                            ->withEnabled(true),
                    ),
            ],
            metadata: (new BetaMetadata)
                ->withUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
            serviceTier: 'auto',
            stopSequences: ['string'],
            system: [
                BetaTextBlockParam::with(text: "Today's date is 2024-06-01.")
                    ->withCacheControl((new BetaCacheControlEphemeral)->withTTL('5m'))
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
            temperature: 1,
            thinking: BetaThinkingConfigEnabled::with(budgetTokens: 1024),
            toolChoice: (new BetaToolChoiceAuto)->withDisableParallelToolUse(true),
            tools: [
                BetaTool::with(
                    inputSchema: (new InputSchema)
                        ->withProperties((object) [])
                        ->withRequired(['location']),
                    name: 'name',
                )
                    ->withCacheControl((new BetaCacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
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
        $params = MessageCountTokensParams::with(
            messages: [BetaMessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );
        $result = $this->client->beta->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $params = MessageCountTokensParams::with(
            messages: [BetaMessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
            mcpServers: [
                BetaRequestMCPServerURLDefinition::with(name: 'name', url: 'url')
                    ->withAuthorizationToken('authorization_token')
                    ->withToolConfiguration(
                        (new BetaRequestMCPServerToolConfiguration)
                            ->withAllowedTools(['string'])
                            ->withEnabled(true),
                    ),
            ],
            system: [
                BetaTextBlockParam::with(text: "Today's date is 2024-06-01.")
                    ->withCacheControl((new BetaCacheControlEphemeral)->withTTL('5m'))
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
            thinking: BetaThinkingConfigEnabled::with(budgetTokens: 1024),
            toolChoice: (new BetaToolChoiceAuto)->withDisableParallelToolUse(true),
            tools: [
                BetaTool::with(
                    inputSchema: (new InputSchema)
                        ->withProperties((object) [])
                        ->withRequired(['location']),
                    name: 'name',
                )
                    ->withCacheControl((new BetaCacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
            ],
            anthropicBeta: ['string'],
        );
        $result = $this->client->beta->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
