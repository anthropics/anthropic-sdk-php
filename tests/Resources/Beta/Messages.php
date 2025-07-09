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
use Anthropic\Models\Beta\BetaToolChoiceAuto;
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
            ->create([
                'maxTokens' => 1024,
                'messages' => [
                    new BetaMessageParam(content: 'Hello, world', role: 'user'),
                ],
                'model' => 'claude-sonnet-4-20250514',
            ])
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
            ->create([
                'maxTokens' => 1024,
                'messages' => [
                    new BetaMessageParam(content: 'Hello, world', role: 'user'),
                ],
                'model' => 'claude-sonnet-4-20250514',
                'container' => 'container',
                'mcpServers' => [
                    new BetaRequestMCPServerURLDefinition(
                        name: 'name',
                        type: 'url',
                        url: 'url',
                        authorizationToken: 'authorization_token',
                        toolConfiguration: new BetaRequestMCPServerToolConfiguration(
                            allowedTools: [
                                'string',
                            ],
                            enabled: true
                        )
                    ),
                ],
                'metadata' => new BetaMetadata(userID: '13803d75-b4b5-4c3e-b2a2-6f21399b021b'),
                'serviceTier' => 'auto',
                'stopSequences' => ['string'],
                'stream' => false,
                'system' => [
                    new BetaTextBlockParam(
                        text: "Today's date is 2024-06-01.",
                        type: 'text',
                        cacheControl: new BetaCacheControlEphemeral(
                            type: 'ephemeral',
                            ttl: '5m'
                        ),
                        citations: [
                            new BetaCitationCharLocationParam(
                                citedText: 'cited_text',
                                documentIndex: 0,
                                documentTitle: 'x',
                                endCharIndex: 0,
                                startCharIndex: 0,
                                type: 'char_location'
                            ),
                        ]
                    ),
            ],
                'temperature' => 1,
                'thinking' => new BetaThinkingConfigEnabled(
                    budgetTokens: 1024,
                    type: 'enabled'
                ),
                'toolChoice' => new BetaToolChoiceAuto(
                    type: 'auto',
                    disableParallelToolUse: true
                ),
                'tools' => [
                    new BetaTool(
                        inputSchema: [
                            'type' => 'object',
                            'properties' => [
                                'location' => [
                                    'description' => 'The city and state, e.g. San Francisco, CA',
                                    'type' => 'string',
                                ],
                                'unit' => [
                                    'description' => 'Unit for the output - one of (celsius, fahrenheit)',
                                    'type' => 'string',
                                ],
                            ],
                            'required' => ['location'],
                        ],
                        name: 'name',
                        cacheControl: new BetaCacheControlEphemeral(
                            type: 'ephemeral',
                            ttl: '5m'
                        ),
                        description: 'Get the current weather in a given location',
                        type: 'custom'
                    ),
                ],
                'topK' => 5,
                'topP' => 0.7,
                'betas' => ['string'],
            ])
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
            ->countTokens([
                'messages' => [new BetaMessageParam(content: 'string', role: 'user')],
                'model' => 'claude-3-7-sonnet-latest',
            ])
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
            ->countTokens([
                'messages' => [new BetaMessageParam(content: 'string', role: 'user')],
                'model' => 'claude-3-7-sonnet-latest',
                'mcpServers' => [
                    new BetaRequestMCPServerURLDefinition(
                        name: 'name',
                        type: 'url',
                        url: 'url',
                        authorizationToken: 'authorization_token',
                        toolConfiguration: new BetaRequestMCPServerToolConfiguration(
                            allowedTools: [
                                'string',
                            ],
                            enabled: true
                        )
                    ),
                ],
                'system' => [
                    new BetaTextBlockParam(
                        text: "Today's date is 2024-06-01.",
                        type: 'text',
                        cacheControl: new BetaCacheControlEphemeral(
                            type: 'ephemeral',
                            ttl: '5m'
                        ),
                        citations: [
                            new BetaCitationCharLocationParam(
                                citedText: 'cited_text',
                                documentIndex: 0,
                                documentTitle: 'x',
                                endCharIndex: 0,
                                startCharIndex: 0,
                                type: 'char_location'
                            ),
                        ]
                    ),
            ],
                'thinking' => new BetaThinkingConfigEnabled(
                    budgetTokens: 1024,
                    type: 'enabled'
                ),
                'toolChoice' => new BetaToolChoiceAuto(
                    type: 'auto',
                    disableParallelToolUse: true
                ),
                'tools' => [
                    new BetaTool(
                        inputSchema: [
                            'type' => 'object',
                            'properties' => [
                                'location' => [
                                    'description' => 'The city and state, e.g. San Francisco, CA',
                                    'type' => 'string',
                                ],
                                'unit' => [
                                    'description' => 'Unit for the output - one of (celsius, fahrenheit)',
                                    'type' => 'string',
                                ],
                            ],
                            'required' => ['location'],
                        ],
                        name: 'name',
                        cacheControl: new BetaCacheControlEphemeral(
                            type: 'ephemeral',
                            ttl: '5m'
                        ),
                        description: 'Get the current weather in a given location',
                        type: 'custom'
                    ),
                ],
                'betas' => ['string'],
            ])
        ;

        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
