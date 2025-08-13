<?php

namespace Tests\Resources;

use Anthropic\Client;
use Anthropic\Messages\CacheControlEphemeral;
use Anthropic\Messages\CitationCharLocationParam;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
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
            messages: [MessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );
        $result = $this->client->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = MessageCreateParams::with(
            maxTokens: 1024,
            messages: [MessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
            metadata: (new Metadata)
                ->withUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
            serviceTier: 'auto',
            stopSequences: ['string'],
            system: [
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
            temperature: 1,
            thinking: ThinkingConfigEnabled::with(budgetTokens: 1024),
            toolChoice: (new ToolChoiceAuto)->withDisableParallelToolUse(true),
            tools: [
                Tool::with(
                    inputSchema: (new InputSchema)
                        ->withProperties((object) [])
                        ->withRequired(['location']),
                    name: 'name',
                )
                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
            ],
            topK: 5,
            topP: 0.7,
        );
        $result = $this->client->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $params = MessageCountTokensParams::with(
            messages: [MessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );
        $result = $this->client->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $params = MessageCountTokensParams::with(
            messages: [MessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
            system: [
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
            thinking: ThinkingConfigEnabled::with(budgetTokens: 1024),
            toolChoice: (new ToolChoiceAuto)->withDisableParallelToolUse(true),
            tools: [
                Tool::with(
                    inputSchema: (new InputSchema)
                        ->withProperties((object) [])
                        ->withRequired(['location']),
                    name: 'name',
                )
                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
            ],
        );
        $result = $this->client->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
