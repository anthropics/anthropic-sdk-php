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
        $params = MessageCreateParams::from(
            maxTokens: 1024,
            messages: [MessageParam::from(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );
        $result = $this->client->messages->create($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $params = MessageCreateParams::from(
            maxTokens: 1024,
            messages: [MessageParam::from(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
            metadata: (new Metadata)
                ->setUserID('13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
            serviceTier: 'auto',
            stopSequences: ['string'],
            system: [
                TextBlockParam::from(text: "Today's date is 2024-06-01.")
                    ->setCacheControl(new CacheControlEphemeral)
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
            temperature: 1,
            thinking: ThinkingConfigEnabled::from(budgetTokens: 1024),
            toolChoice: (new ToolChoiceAuto)->setDisableParallelToolUse(true),
            tools: [
                Tool::from(
                    inputSchema: (new InputSchema)
                        ->setProperties((object) [])
                        ->setRequired(['location']),
                    name: 'name',
                )
                    ->setCacheControl(new CacheControlEphemeral)
                    ->setDescription('Get the current weather in a given location')
                    ->setType('custom'),
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
        $params = MessageCountTokensParams::from(
            messages: [MessageParam::from(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );
        $result = $this->client->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $params = MessageCountTokensParams::from(
            messages: [MessageParam::from(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
            system: [
                TextBlockParam::from(text: "Today's date is 2024-06-01.")
                    ->setCacheControl(new CacheControlEphemeral)
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
            thinking: ThinkingConfigEnabled::from(budgetTokens: 1024),
            toolChoice: (new ToolChoiceAuto)->setDisableParallelToolUse(true),
            tools: [
                Tool::from(
                    inputSchema: (new InputSchema)
                        ->setProperties((object) [])
                        ->setRequired(['location']),
                    name: 'name',
                )
                    ->setCacheControl(new CacheControlEphemeral)
                    ->setDescription('Get the current weather in a given location')
                    ->setType('custom'),
            ],
        );
        $result = $this->client->messages->countTokens($params);

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
