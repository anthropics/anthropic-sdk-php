<?php

namespace Tests\Resources;

use Anthropic\Client;
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
        $result = $this->client->messages->create(
            maxTokens: 1024,
            messages: [MessageParam::with(content: 'Hello, world', role: 'user')],
            model: 'claude-sonnet-4-20250514',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->messages->create(
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
                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
            ],
            topK: 5,
            topP: 0.7,
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this->client->messages->countTokens(
            messages: [MessageParam::with(content: 'string', role: 'user')],
            model: 'claude-3-7-sonnet-latest',
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this->client->messages->countTokens(
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
                    ->withCacheControl((new CacheControlEphemeral)->withTTL('5m'))
                    ->withDescription('Get the current weather in a given location')
                    ->withType('custom'),
            ],
        );

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
