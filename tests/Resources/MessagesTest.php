<?php

namespace Tests\Resources;

use Anthropic\Client;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\CitationCharLocationParam;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\Tool\InputSchema;
use Anthropic\Models\ToolChoiceAuto;
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
            ->messages
            ->create(
                [
                    'maxTokens' => 1024,
                    'messages' => [new MessageParam(content: 'Hello, world', role: 'user')],
                    'model' => 'claude-sonnet-4-20250514',
                    'stream' => true,
                ]
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->messages
            ->create(
                [
                    'maxTokens' => 1024,
                    'messages' => [new MessageParam(content: 'Hello, world', role: 'user')],
                    'model' => 'claude-sonnet-4-20250514',
                    'metadata' => new Metadata(
                        userID: '13803d75-b4b5-4c3e-b2a2-6f21399b021b'
                    ),
                    'serviceTier' => 'auto',
                    'stopSequences' => ['string'],
                    'stream' => true,
                    'system' => [
                        new TextBlockParam(
                            text: "Today's date is 2024-06-01.",
                            cacheControl: new CacheControlEphemeral(),
                            citations: [
                                new CitationCharLocationParam(
                                    citedText: 'cited_text',
                                    documentIndex: 0,
                                    documentTitle: 'x',
                                    endCharIndex: 0,
                                    startCharIndex: 0,
                                ),
                            ],
                        ),
                    ],
                    'temperature' => 1,
                    'thinking' => new ThinkingConfigEnabled(budgetTokens: 1024),
                    'toolChoice' => new ToolChoiceAuto(disableParallelToolUse: true),
                    'tools' => [
                        new Tool(
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
                            cacheControl: new CacheControlEphemeral(),
                            description: 'Get the current weather in a given location',
                            type: 'custom',
                        ),
                ],
                    'topK' => 5,
                    'topP' => 0.7,
                ]
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokens(): void
    {
        $result = $this
            ->client
            ->messages
            ->countTokens(
                [
                    'messages' => [new MessageParam(content: 'string', role: 'user')],
                    'model' => 'claude-3-7-sonnet-latest',
                ]
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }

    #[Test]
    public function testCountTokensWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->messages
            ->countTokens(
                [
                    'messages' => [new MessageParam(content: 'string', role: 'user')],
                    'model' => 'claude-3-7-sonnet-latest',
                    'system' => [
                        new TextBlockParam(
                            text: "Today's date is 2024-06-01.",
                            cacheControl: new CacheControlEphemeral(),
                            citations: [
                                new CitationCharLocationParam(
                                    citedText: 'cited_text',
                                    documentIndex: 0,
                                    documentTitle: 'x',
                                    endCharIndex: 0,
                                    startCharIndex: 0,
                                ),
                            ],
                        ),
                    ],
                    'thinking' => new ThinkingConfigEnabled(budgetTokens: 1024),
                    'toolChoice' => new ToolChoiceAuto(disableParallelToolUse: true),
                    'tools' => [
                        new Tool(
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
                            cacheControl: new CacheControlEphemeral(),
                            description: 'Get the current weather in a given location',
                            type: 'custom',
                        ),
                ],
                ]
            )
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
