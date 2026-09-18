<?php

declare(strict_types=1);

namespace Tests\Lib\Tools;

use Anthropic\Beta\Messages\BetaCompact20260112Edit;
use Anthropic\Beta\Messages\BetaCompactionBlock;
use Anthropic\Beta\Messages\BetaCompactionConfig;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaContextManagementConfig;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Client;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Anthropic\Lib\Tools\BetaToolRunner;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @coversNothing
 */
final class BetaToolRunnerTest extends TestCase
{
    private const CONTAINER = ['id' => 'container_123', 'expires_at' => '2025-01-01T00:00:00Z', 'skills' => []];

    private const PAUSED_CONTENT = [
        ['type' => 'text', 'text' => 'Let me look that up.'],
        [
            'type' => 'server_tool_use',
            'id' => 'srvtoolu_1',
            'name' => 'web_search',
            'input' => ['query' => 'weather in SF'],
        ],
    ];

    private const COMPACTION_CONTENT = [
        ['type' => 'compaction', 'content' => 'Summary of the conversation so far.'],
    ];

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'test-api-key',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    // -------------------------------------------------------------------------
    // Runner is iterable, yields each BetaMessage
    // -------------------------------------------------------------------------

    #[Test]
    public function testYieldsEachMessageDuringLoop(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertCount(2, $messages);
        $this->assertSame('tool_use', $messages[0]->content[0]->type);
        $this->assertSame('text', $messages[1]->content[0]->type);
    }

    // -------------------------------------------------------------------------
    // Loop stops when no tool_use blocks
    // -------------------------------------------------------------------------

    #[Test]
    public function testLoopStopsWhenNoToolUseBlocks(): void
    {
        $this->transporter->addResponse($this->textResponse('Hello!'));

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hi']],
            model: 'claude-opus-4-6',
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertCount(1, $messages);
        $this->assertCount(1, $this->transporter->getRequests());
    }

    // -------------------------------------------------------------------------
    // Terminal turns (refusal, max_tokens) are final even when they carry a tool_use block
    // -------------------------------------------------------------------------

    #[Test]
    public function testRefusalTurnWithToolUseIsTerminal(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'Paris'], stopReason: 'refusal')
        );
        // Must never be requested: the refusal turn ends the loop.
        $this->transporter->addResponse($this->textResponse('Sunny in Paris.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in Paris?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertFalse($called, 'Tool in a refusal-terminated turn must not be executed');
        $this->assertCount(1, $messages);
        $this->assertSame('refusal', $messages[0]->stopReason);
        $this->assertInstanceOf(BetaToolUseBlock::class, $messages[0]->content[0]);
        $this->assertCount(1, $this->transporter->getRequests());
    }

    #[Test]
    public function testMaxTokensTurnWithToolUseIsTerminal(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'Paris'], stopReason: 'max_tokens')
        );
        // Must never be requested: the truncated turn ends the loop.
        $this->transporter->addResponse($this->textResponse('Sunny in Paris.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $final = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in Paris?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        )->runUntilDone();

        $this->assertFalse($called, 'Tool in a max_tokens-truncated turn must not be executed');
        $this->assertSame('max_tokens', $final->stopReason);
        $this->assertInstanceOf(BetaToolUseBlock::class, $final->content[0]);
        $this->assertCount(1, $this->transporter->getRequests());
    }

    // -------------------------------------------------------------------------
    // History: assistant message + tool results appended before next call
    // -------------------------------------------------------------------------

    #[Test]
    public function testAssistantMessageAndToolResultsAppendedToHistory(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'Paris']));
        $this->transporter->addResponse($this->textResponse('Rainy in Paris.'));

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in Paris?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        ) as $_);

        $body = $this->requestBody(1);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        $this->assertCount(3, $messages);
        $this->assertSame('user', $messages[0]['role']);
        $this->assertSame('assistant', $messages[1]['role']);
        $this->assertSame('user', $messages[2]['role']);

        /** @var list<array<string, mixed>> $content2 */
        $content2 = $messages[2]['content'];
        $this->assertSame('tool_result', $content2[0]['type']);
        $this->assertSame('tool_1', $content2[0]['tool_use_id']);
    }

    // -------------------------------------------------------------------------
    // runUntilDone() returns final BetaMessage
    // -------------------------------------------------------------------------

    #[Test]
    public function testRunUntilDoneReturnsFinalMessage(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'NYC']));
        $this->transporter->addResponse($this->textResponse('Sunny in NYC.'));

        $final = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in NYC?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        )->runUntilDone();

        $textBlock = $final->content[0];
        $this->assertInstanceOf(BetaTextBlock::class, $textBlock);
        $this->assertSame('Sunny in NYC.', $textBlock->text);
    }

    // -------------------------------------------------------------------------
    // Plain (non-runnable) tool definitions are forwarded to the API
    // -------------------------------------------------------------------------

    #[Test]
    public function testPlainToolDefinitionIsForwardedToApi(): void
    {
        $this->transporter->addResponse($this->textResponse('Done.'));

        $plainTool = [
            'name' => 'web_search',
            'type' => 'web_search_20250305',
        ];

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Search something']],
            model: 'claude-opus-4-6',
            tools: [$plainTool],
        ) as $_);

        $body = $this->requestBody(0);

        /** @var list<array<string, mixed>> $tools */
        $tools = $body['tools'];

        $this->assertCount(1, $tools);
        $this->assertSame('web_search', $tools[0]['name']);
        $this->assertSame('web_search_20250305', $tools[0]['type']);
    }

    // -------------------------------------------------------------------------
    // Missing runnable tool returns is_error result, does not throw
    // -------------------------------------------------------------------------

    #[Test]
    public function testMissingToolReturnsErrorResult(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('nonexistent_tool', []));
        $this->transporter->addResponse($this->textResponse('Cannot help.'));

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Do something']],
            model: 'claude-opus-4-6',
            tools: [],
        ) as $_);

        $body = $this->requestBody(1);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        /** @var array<string, mixed> $lastMsg */
        $lastMsg = end($messages);

        /** @var list<array<string, mixed>> $lastContent */
        $lastContent = $lastMsg['content'];

        $this->assertTrue($lastContent[0]['is_error']);

        /** @var string $errContent */
        $errContent = $lastContent[0]['content'];
        $this->assertStringContainsString("'nonexistent_tool' not found", $errContent);
    }

    // -------------------------------------------------------------------------
    // tool_removal: a call to a currently-removed tool behaves as if never defined
    // -------------------------------------------------------------------------

    #[Test]
    public function testToolRemovedMidConversationIsTreatedAsNotFound(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Cannot help.'));
        // Baseline: the same tool called when it was never defined at all.
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Cannot help.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'Weather?'],
                ['role' => 'system', 'content' => [
                    ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']],
                ]],
            ],
            model: 'claude-opus-4-6',
            tools: [$tool],
        ) as $_);

        $this->assertFalse($called, 'Removed tool must not be executed');
        $removedResult = $this->lastToolResult($this->requestBody(1));

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [],
        ) as $_);

        $neverDefinedResult = $this->lastToolResult($this->requestBody(3));

        $this->assertTrue($removedResult['is_error']);
        $this->assertSame($neverDefinedResult['content'], $removedResult['content']);
        $this->assertSame($neverDefinedResult['is_error'], $removedResult['is_error']);
    }

    #[Test]
    public function testToolRemovalNestedInMidConvSystemBlockIsHonored(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Cannot help.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        // The tool_removal rides one level down, inside a mid_conv_system
        // block; the fold walks exactly that one level.
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'Weather?'],
                ['role' => 'system', 'content' => [
                    ['type' => 'mid_conv_system', 'content' => [
                        ['type' => 'text', 'text' => 'the weather tool is gone'],
                        ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']],
                    ]],
                ]],
            ],
            model: 'claude-opus-4-6',
            tools: [$tool],
        ) as $_);

        $this->assertFalse($called, 'Tool removed inside a mid_conv_system block must not be executed');
        $this->assertTrue($this->lastToolResult($this->requestBody(1))['is_error']);
    }

    #[Test]
    public function testToolAddedBackAfterRemovalExecutesNormally(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'Weather?'],
                ['role' => 'system', 'content' => [
                    BetaRequestToolRemovalBlock::with(tool: BetaToolChangeToolReference::with(name: 'get_weather')),
                ]],
                ['role' => 'system', 'content' => [
                    BetaRequestToolAdditionBlock::with(tool: BetaToolChangeToolReference::with(name: 'get_weather')),
                ]],
            ],
            model: 'claude-opus-4-6',
            tools: [$tool],
        ) as $_);

        $this->assertTrue($called, 'Re-added tool must be executed');

        $result = $this->lastToolResult($this->requestBody(1));
        $this->assertArrayNotHasKey('is_error', $result);

        /** @var string $content */
        $content = $result['content'];
        $this->assertStringContainsString('"temperature":72', $content);
    }

    // -------------------------------------------------------------------------
    // tool_removal / tool_addition supplied through the param-mutation APIs
    // (pushMessages / setMessagesParams) are honored, not just messages
    // present in the initial params.
    // -------------------------------------------------------------------------

    #[Test]
    public function testToolRemovalPushedBetweenTurnsIsHonoredOnNextToolUse(): void
    {
        $this->transporter->addResponse($this->textResponse('Let me check the weather.', 'msg_1'));
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF'], 'msg_2'));
        $this->transporter->addResponse($this->textResponse('Cannot help.', 'msg_3'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        );

        $retired = false;
        foreach ($runner as $message) {
            if (!$retired && $message->content[0] instanceof BetaTextBlock) {
                // Between turns: retire the tool via pushMessages() before the
                // model's follow-up tool_use for it.
                $retired = true;
                $runner->pushMessages(
                    ['role' => 'assistant', 'content' => $message->content],
                    ['role' => 'system', 'content' => [
                        ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']],
                    ]],
                );
            }
        }

        $this->assertFalse($called, 'Tool removed via pushMessages() must not be executed');

        $result = $this->lastToolResult($this->requestBody(2));
        $this->assertTrue($result['is_error']);

        /** @var string $content */
        $content = $result['content'];
        $this->assertStringContainsString("'get_weather' not found", $content);
    }

    #[Test]
    public function testToolRemovalSetViaSetMessagesParamsBetweenTurnsIsHonored(): void
    {
        $this->transporter->addResponse($this->textResponse('Let me check the weather.', 'msg_1'));
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF'], 'msg_2'));
        $this->transporter->addResponse($this->textResponse('Cannot help.', 'msg_3'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        );

        $retired = false;
        foreach ($runner as $message) {
            if (!$retired && $message->content[0] instanceof BetaTextBlock) {
                // Between turns: rewrite history via setMessagesParams() so it
                // now carries a tool_removal for get_weather.
                $retired = true;
                $runner->setMessagesParams(
                    /**
                     * @param array<string, mixed> $params
                     *
                     * @return array<string, mixed>
                     */
                    function (array $params) use ($message): array {
                        /** @var list<array<string, mixed>> $existing */
                        $existing = $params['messages'];

                        return array_merge($params, [
                            'messages' => array_merge($existing, [
                                ['role' => 'assistant', 'content' => $message->content],
                                ['role' => 'system', 'content' => [
                                    BetaRequestToolRemovalBlock::with(tool: BetaToolChangeToolReference::with(name: 'get_weather')),
                                ]],
                            ]),
                        ]);
                    }
                );
            }
        }

        $this->assertFalse($called, 'Tool removed via setMessagesParams() must not be executed');

        $result = $this->lastToolResult($this->requestBody(2));
        $this->assertTrue($result['is_error']);

        /** @var string $content */
        $content = $result['content'];
        $this->assertStringContainsString("'get_weather' not found", $content);
    }

    #[Test]
    public function testToolRemovalPushedInSameTurnAsToolUseIsHonored(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Cannot help.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        );

        foreach ($runner as $message) {
            if ($message->content[0] instanceof BetaToolUseBlock) {
                // Same turn: the pushed history ends with the assistant tool_use,
                // so the runner still dispatches it — after applying the removal.
                $runner->pushMessages(
                    ['role' => 'system', 'content' => [
                        ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']],
                    ]],
                    ['role' => 'assistant', 'content' => $message->content],
                );
            }
        }

        $this->assertFalse($called, 'Tool removed in the same turn must not be executed');

        $result = $this->lastToolResult($this->requestBody(1));
        $this->assertTrue($result['is_error']);

        /** @var string $content */
        $content = $result['content'];
        $this->assertStringContainsString("'get_weather' not found", $content);
    }

    #[Test]
    public function testToolAdditionPushedInSameTurnReEnablesExecution(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'Weather?'],
                ['role' => 'system', 'content' => [
                    ['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']],
                ]],
            ],
            model: 'claude-opus-4-6',
            tools: [$tool],
        );

        foreach ($runner as $message) {
            if ($message->content[0] instanceof BetaToolUseBlock) {
                // Re-add the previously removed tool via pushMessages() before
                // this turn's tool_use is dispatched.
                $runner->pushMessages(
                    ['role' => 'system', 'content' => [
                        BetaRequestToolAdditionBlock::with(tool: BetaToolChangeToolReference::with(name: 'get_weather')),
                    ]],
                    ['role' => 'assistant', 'content' => $message->content],
                );
            }
        }

        $this->assertTrue($called, 'Tool re-added via pushMessages() must be executed');

        $result = $this->lastToolResult($this->requestBody(1));
        $this->assertArrayNotHasKey('is_error', $result);

        /** @var string $content */
        $content = $result['content'];
        $this->assertStringContainsString('"temperature":72', $content);
    }

    // -------------------------------------------------------------------------
    // Tool run() throws → is_error result, exception not propagated
    // -------------------------------------------------------------------------

    #[Test]
    public function testToolExecutionErrorIsReturnedAsErrorResult(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sorry, error occurred.'));

        $errorTool = $this->makeWeatherTool(function (): never {
            throw new \RuntimeException('Service unavailable');
        });

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$errorTool],
        ) as $message) {
            $messages[] = $message;
        }

        // Loop continues even after the tool error
        $this->assertCount(2, $messages);

        $body = $this->requestBody(1);

        /** @var list<array<string, mixed>> $msgs */
        $msgs = $body['messages'];

        /** @var array<string, mixed> $lastMsg */
        $lastMsg = end($msgs);

        /** @var list<array<string, mixed>> $lastContent */
        $lastContent = $lastMsg['content'];

        $this->assertTrue($lastContent[0]['is_error']);

        /** @var string $errContent */
        $errContent = $lastContent[0]['content'];
        $this->assertStringContainsString('Service unavailable', $errContent);
    }

    // -------------------------------------------------------------------------
    // setMessagesParams(): full replacement and mutator closure
    // -------------------------------------------------------------------------

    #[Test]
    public function testSetMessagesParamsFullReplacement(): void
    {
        $this->transporter->addResponse($this->textResponse('Howdy.'));

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Original']],
            model: 'claude-opus-4-6',
        );

        $runner->setMessagesParams([
            'maxTokens' => 512,
            'messages' => [['role' => 'user', 'content' => 'Replaced']],
            'model' => 'claude-haiku-4-5',
        ]);

        foreach ($runner as $_);

        $body = $this->requestBody(0);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        $this->assertSame(512, $body['max_tokens']);
        $this->assertSame('claude-haiku-4-5', $body['model']);
        $this->assertSame('Replaced', $messages[0]['content']);
    }

    #[Test]
    public function testSetMessagesParamsMutatorClosure(): void
    {
        $this->transporter->addResponse($this->textResponse('Got it.'));

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hello']],
            model: 'claude-opus-4-6',
        );

        $runner->setMessagesParams(
            /**
             * @param array<string, mixed> $params
             *
             * @return array<string, mixed>
             */
            function (array $params): array {
                /** @var list<array<string, mixed>> $existing */
                $existing = $params['messages'];

                return array_merge($params, [
                    'maxTokens' => 256,
                    'messages' => array_merge($existing, [
                        ['role' => 'user', 'content' => 'Appended'],
                    ]),
                ]);
            }
        );

        foreach ($runner as $_);

        $body = $this->requestBody(0);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        $this->assertSame(256, $body['max_tokens']);
        $this->assertCount(2, $messages);
        $this->assertSame('Appended', $messages[1]['content']);
    }

    // -------------------------------------------------------------------------
    // pushMessages() appends messages to history
    // -------------------------------------------------------------------------

    #[Test]
    public function testPushMessages(): void
    {
        $this->transporter->addResponse($this->textResponse('Done.'));

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'First']],
            model: 'claude-opus-4-6',
        );

        $runner->pushMessages(
            ['role' => 'assistant', 'content' => 'Response A'],
            ['role' => 'user', 'content' => 'Second'],
        );

        foreach ($runner as $_);

        $body = $this->requestBody(0);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        $this->assertCount(3, $messages);
        $this->assertSame('First', $messages[0]['content']);
        $this->assertSame('Response A', $messages[1]['content']);
        $this->assertSame('Second', $messages[2]['content']);
    }

    // -------------------------------------------------------------------------
    // getParams() exposes current state
    // -------------------------------------------------------------------------

    #[Test]
    public function testGetParamsReturnsCurrentState(): void
    {
        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hello']],
            model: 'claude-opus-4-6',
            maxIterations: 5,
            extraParams: ['temperature' => 0.7],
        );

        $params = $runner->getParams();

        /** @var list<array<string, mixed>> $messages */
        $messages = $params['messages'];

        $this->assertSame(1024, $params['maxTokens']);
        $this->assertSame('claude-opus-4-6', $params['model']);
        $this->assertSame(5, $params['maxIterations']);
        $this->assertSame(0.7, $params['temperature']);
        $this->assertSame('Hello', $messages[0]['content']);
    }

    #[Test]
    public function testGetParamsReflectsMutations(): void
    {
        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hello']],
            model: 'claude-opus-4-6',
        );

        $runner->setMessagesParams(['maxTokens' => 512, 'model' => 'claude-haiku-4-5',
            'messages' => [['role' => 'user', 'content' => 'Hello']]]);

        $params = $runner->getParams();

        $this->assertSame(512, $params['maxTokens']);
        $this->assertSame('claude-haiku-4-5', $params['model']);
    }

    // -------------------------------------------------------------------------
    // Mutation during iteration skips auto-appending assistant message
    // -------------------------------------------------------------------------

    #[Test]
    public function testMutationDuringIterationSkipsAutoAppend(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'Tokyo']));
        $this->transporter->addResponse($this->textResponse('Cloudy in Tokyo.'));

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        );

        foreach ($runner as $message) {
            $block = $message->content[0];

            if ($block instanceof BetaToolUseBlock) {
                // Caller takes manual control of history — builds custom tool result
                $runner->pushMessages(
                    ['role' => 'assistant', 'content' => $message->content],
                    ['role' => 'user', 'content' => [
                        ['type' => 'tool_result', 'tool_use_id' => $block->id, 'content' => 'custom result'],
                    ]],
                );
            }
        }

        $body = $this->requestBody(1);

        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        // History should contain the manually pushed messages, not a duplicate auto-append
        $roles = array_column($messages, 'role');
        $assistantCount = count(array_filter($roles, fn ($r) => 'assistant' === $r));
        $this->assertSame(1, $assistantCount, 'Assistant message should appear exactly once');

        /** @var array<string, mixed> $lastMsg */
        $lastMsg = end($messages);

        /** @var list<array<string, mixed>> $lastContent */
        $lastContent = $lastMsg['content'];
        $this->assertSame('custom result', $lastContent[0]['content']);
    }

    // -------------------------------------------------------------------------
    // maxIterations caps API calls
    // -------------------------------------------------------------------------

    #[Test]
    public function testMaxIterationsStopsLoop(): void
    {
        for ($i = 1; $i <= 5; ++$i) {
            $this->transporter->addResponse(
                $this->toolUseResponse('get_weather', ['location' => "City {$i}"], "msg_{$i}", "tool_{$i}")
            );
        }

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            maxIterations: 2,
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertCount(2, $messages);
        $this->assertCount(2, $this->transporter->getRequests());
    }

    #[Test]
    public function testStopsNaturallyBeforeMaxIterations(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sunny!'));

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            maxIterations: 10,
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertCount(2, $messages);
    }

    // -------------------------------------------------------------------------
    // pause_turn / compaction: the unfinished turn is sent back so the server resumes it
    // -------------------------------------------------------------------------

    #[Test]
    public function testPauseTurnIsSentBackAndResumed(): void
    {
        $this->transporter->addResponse($this->pauseTurnResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $final = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in SF?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool(), ['name' => 'web_search', 'type' => 'web_search_20250305']],
        )->runUntilDone();

        $this->assertSame('end_turn', $final->stopReason);
        $this->assertCount(2, $this->transporter->getRequests());

        $this->assertEquals(
            [
                ['role' => 'user', 'content' => 'Weather in SF?'],
                ['role' => 'assistant', 'content' => self::PAUSED_CONTENT],
            ],
            $this->requestBody(1)['messages'],
        );
    }

    #[Test]
    public function testPauseTurnStopsAtMaxIterations(): void
    {
        for ($i = 1; $i <= 5; ++$i) {
            $this->transporter->addResponse($this->pauseTurnResponse("msg_{$i}"));
        }

        $final = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in SF?']],
            model: 'claude-opus-4-6',
            tools: [['name' => 'web_search', 'type' => 'web_search_20250305']],
            maxIterations: 3,
        )->runUntilDone();

        $this->assertSame('pause_turn', $final->stopReason);
        $this->assertCount(3, $this->transporter->getRequests());
    }

    #[Test]
    public function testCompactionTurnIsSentBackAndResumed(): void
    {
        $this->transporter->addResponse($this->compactionResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $called = false;
        $tool = $this->makeWeatherTool(function () use (&$called): void {
            $called = true;
        });

        $messages = [];
        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather in SF?']],
            model: 'claude-opus-4-6',
            tools: [$tool],
        ) as $message) {
            $messages[] = $message;
        }

        $this->assertCount(2, $messages);
        $this->assertInstanceOf(BetaCompactionBlock::class, $messages[0]->content[0]);
        $this->assertSame('end_turn', $messages[1]->stopReason);
        $this->assertFalse($called);
        $this->assertCount(2, $this->transporter->getRequests());

        // The compaction turn goes back unchanged as the last message, with no tool_result turn after it.
        $this->assertEquals(
            [
                ['role' => 'user', 'content' => 'Weather in SF?'],
                ['role' => 'assistant', 'content' => self::COMPACTION_CONTENT],
            ],
            $this->requestBody(1)['messages'],
        );
    }

    #[Test]
    public function testDetermineNextStepFromStopReasonCoversEveryStopReason(): void
    {
        $determineNextStep = new \ReflectionMethod(BetaToolRunner::class, 'determineNextStepFromStopReason');
        $expected = [
            'tool_use' => 'run_tools',
            'pause_turn' => 'resume',
            'compaction' => 'resume',
            'end_turn' => 'stop',
            'stop_sequence' => 'stop',
            'max_tokens' => 'stop',
            'model_context_window_exceeded' => 'stop',
            'refusal' => 'stop',
        ];

        foreach (BetaStopReason::cases() as $case) {
            $this->assertArrayHasKey($case->value, $expected, "stop_reason {$case->value} has no expected bucket");
            $this->assertSame(
                $expected[$case->value],
                $determineNextStep->invoke(null, $case->value),
                "stop_reason {$case->value}",
            );
        }

        // A stop reason this SDK does not know yet must stop the loop, never throw.
        $this->assertSame('stop', $determineNextStep->invoke(null, 'some_future_reason'));
        $this->assertSame('stop', $determineNextStep->invoke(null, null));
    }

    // -------------------------------------------------------------------------
    // compactBeforeNextTurn(): one compaction request, sent once the current turn is complete
    // -------------------------------------------------------------------------

    #[Test]
    public function testCompactBeforeNextTurnIsSentAfterTheToolsRun(): void
    {
        $compacted = [
            ['type' => 'compaction', 'content' => 'Summary so far.', 'signature' => 'sig_01'],
            // A block type this SDK version does not model.
            ['type' => 'some_future_listing', 'server_name' => 'docs', 'tools' => [['name' => 'search', 'opts' => ['a' => 1]]]],
        ];

        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse($compacted));
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner(
            // The compaction request is not a model turn, so both real turns still fit.
            maxIterations: 2,
            extraParams: [
                'betas' => ['compact-2026-09-04'],
                'contextManagement' => ['edits' => [['type' => 'clear_tool_uses_20250919']]],
            ],
        );

        $yielded = [];
        foreach ($runner as $message) {
            $yielded[] = $message;
            if ('tool_use' === $message->stopReason) {
                $runner->compactBeforeNextTurn(['type' => 'summarize', 'instructions' => 'Keep the city.']);
            }
        }

        $this->assertSame(['tool_use', 'compaction', 'end_turn'], array_column($yielded, 'stopReason'));
        $summary = $yielded[1]->content[0];
        $this->assertInstanceOf(BetaCompactionBlock::class, $summary);
        $this->assertSame('Summary so far.', $summary->content);

        [$first, $compaction, $after] = $this->requestBodies();
        $this->assertSame(['type' => 'summarize', 'instructions' => 'Keep the city.'], $compaction['compaction']);
        $this->assertArrayNotHasKey('context_management', $compaction);
        $this->assertEquals(
            [
                ['role' => 'user', 'content' => 'What is the weather in SF?'],
                ['role' => 'assistant', 'content' => [
                    ['type' => 'tool_use', 'id' => 'tool_1', 'name' => 'get_weather', 'input' => ['location' => 'SF']],
                ]],
                ['role' => 'user', 'content' => [
                    ['type' => 'tool_result', 'tool_use_id' => 'tool_1', 'content' => '{"location":"SF","temperature":72}'],
                ]],
            ],
            $compaction['messages'],
        );

        // The history is now the compaction response as it came.
        $this->assertEquals([['role' => 'assistant', 'content' => $compacted]], $after['messages']);
        $this->assertArrayNotHasKey('compaction', $after);
        $this->assertSame($first['context_management'], $after['context_management']);

        // The beta is the caller's to pass; the runner sends what it was given and nothing more.
        foreach ($this->transporter->getRequests() as $request) {
            $this->assertSame('compact-2026-09-04', $request->getHeaderLine('anthropic-beta'));
        }
    }

    #[Test]
    public function testCompactBeforeNextTurnBeforeTheFirstIterationIsTheFirstRequest(): void
    {
        $this->transporter->addResponse($this->compactedResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();
        $runner->compactBeforeNextTurn();

        $stopReasons = [];
        foreach ($runner as $message) {
            $stopReasons[] = $message->stopReason;
        }

        $this->assertSame(['compaction', 'end_turn'], $stopReasons);

        [$compaction, $after] = $this->requestBodies();
        $this->assertSame(['type' => 'summarize'], $compaction['compaction']);
        $this->assertEquals([['role' => 'user', 'content' => 'What is the weather in SF?']], $compaction['messages']);
        $this->assertEquals(self::compactionBlockAlone(), $after['messages']);
    }

    #[Test]
    public function testCompactBeforeNextTurnAgainReplacesThePendingCompaction(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();
        foreach ($runner as $message) {
            if ('tool_use' === $message->stopReason) {
                $runner->compactBeforeNextTurn(['type' => 'summarize', 'instructions' => 'Keep the city.']);
                $runner->compactBeforeNextTurn(['type' => 'summarize', 'instructions' => 'Keep the units.']);
            }
        }

        $this->assertSame(
            [null, ['type' => 'summarize', 'instructions' => 'Keep the units.'], null],
            array_map(fn (array $body) => $body['compaction'] ?? null, $this->requestBodies()),
        );
    }

    #[Test]
    public function testCompactBeforeNextTurnWaitsOutAPausedTurn(): void
    {
        $this->transporter->addResponse($this->pauseTurnResponse());
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();
        foreach ($runner as $message) {
            if ('pause_turn' === $message->stopReason) {
                $runner->compactBeforeNextTurn();
            }
        }

        [, $resumed, $compaction, $after] = $this->requestBodies();
        $this->assertArrayNotHasKey('compaction', $resumed);
        $this->assertEquals(['role' => 'assistant', 'content' => self::PAUSED_CONTENT], $this->lastMessage($resumed));
        $this->assertSame(['type' => 'summarize'], $compaction['compaction']);
        $this->assertSame('tool_result', $this->lastToolResult($compaction)['type']);
        $this->assertEquals(self::compactionBlockAlone(), $after['messages']);
    }

    #[Test]
    public function testCompactBeforeNextTurnOnTheFinalTurnIsSentBeforeStopping(): void
    {
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));
        $this->transporter->addResponse($this->compactedResponse());

        // The final answer is also the last iteration allowed; the compaction still goes out.
        $runner = $this->compactRunner(maxIterations: 1);

        $stopReasons = [];
        foreach ($runner as $message) {
            $stopReasons[] = $message->stopReason;
            if ('end_turn' === $message->stopReason) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertSame(['end_turn', 'compaction'], $stopReasons);

        [, $compaction] = $this->requestBodies();
        $this->assertSame(['type' => 'summarize'], $compaction['compaction']);
        $this->assertEquals(
            [
                ['role' => 'user', 'content' => 'What is the weather in SF?'],
                ['role' => 'assistant', 'content' => [['type' => 'text', 'text' => 'Sunny in SF.']]],
            ],
            $compaction['messages'],
        );
        $this->assertEquals(self::compactionBlockAlone(), $this->currentMessages($runner));
    }

    #[Test]
    public function testPendingCompactionIsSkippedOnAFinalTurnWithUnrunToolCalls(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'SF'], stopReason: 'max_tokens')
        );

        $runner = $this->compactRunner();

        $stopReasons = [];
        $warnings = $this->captureWarnings(function () use ($runner, &$stopReasons): void {
            foreach ($runner as $message) {
                $stopReasons[] = $message->stopReason;
                $runner->compactBeforeNextTurn();
            }
        });

        $this->assertSame(['max_tokens'], $stopReasons);
        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertCount(1, $warnings);
        $this->assertStringContainsString('pending compaction was skipped', $warnings[0]);
        $this->assertStringContainsString('max_tokens', $warnings[0]);
    }

    #[Test]
    public function testPendingCompactionIsSkippedWhenMaxIterationsEndsTheRun(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));

        $runner = $this->compactRunner(maxIterations: 1);
        foreach ($runner as $_) {
            $runner->compactBeforeNextTurn();
        }

        $this->assertCount(1, $this->transporter->getRequests());
    }

    #[Test]
    public function testCompactBeforeNextTurnOnTheCompactionResponseIsIgnored(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();

        $stopReasons = [];
        foreach ($runner as $message) {
            $stopReasons[] = $message->stopReason;
            if ('end_turn' !== $message->stopReason) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertSame(['tool_use', 'compaction', 'end_turn'], $stopReasons);
        $this->assertSame(
            [null, ['type' => 'summarize'], null],
            array_map(fn (array $body) => $body['compaction'] ?? null, $this->requestBodies()),
        );
    }

    // -------------------------------------------------------------------------
    // compactBeforeNextTurn(): the history becomes the compaction response, as it came
    // -------------------------------------------------------------------------

    /**
     * @param list<array<string, mixed>> $content
     */
    #[Test]
    #[DataProvider('responsesWithoutASummary')]
    public function testCompactionWithoutASummaryKeepsTheHistoryAndWarns(array $content, string $stopReason): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse($content, $stopReason));
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();

        $warnings = $this->captureWarnings(function () use ($runner): void {
            $yielded = 0;
            foreach ($runner as $_) {
                // The second call is made on the compaction response, so it is ignored: no retry is sent.
                if (++$yielded <= 2) {
                    $runner->compactBeforeNextTurn();
                }
            }
        });

        [, $compaction, $after] = $this->requestBodies();
        $this->assertEquals($compaction['messages'], $after['messages']);
        $this->assertArrayNotHasKey('compaction', $after);
        $this->assertSame(['Compaction produced no summary; keeping the conversation as it is.'], $warnings);
    }

    /**
     * @return iterable<string, array{list<array<string, mixed>>, string}>
     */
    public static function responsesWithoutASummary(): iterable
    {
        yield 'block without content' => [[['type' => 'compaction', 'content' => null]], 'compaction'];

        yield 'no content' => [[], 'max_tokens'];
    }

    #[Test]
    public function testMessagesCannotBeReplacedWhileCompacting(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse());
        $this->transporter->addResponse($this->textResponse('Sunny in SF.'));

        $runner = $this->compactRunner();

        $refused = [];
        foreach ($runner as $message) {
            if ('tool_use' === $message->stopReason) {
                $runner->compactBeforeNextTurn();
            } elseif ('compaction' === $message->stopReason) {
                $changes = [
                    fn () => $runner->pushMessages(['role' => 'user', 'content' => 'And in NYC?']),
                    fn () => $runner->setMessagesParams(['messages' => []]),
                    fn () => $runner->setMessagesParams(fn (array $params): array => ['messages' => []] + $params),
                ];
                foreach ($changes as $change) {
                    try {
                        $change();
                    } catch (\LogicException $e) {
                        $refused[] = $e->getMessage();
                    }
                }

                // Other params can still change, and the change is kept after the history is replaced.
                $runner->setMessagesParams(fn (array $params): array => ['maxTokens' => 2048] + $params);
            }
        }

        $this->assertCount(3, $refused);
        foreach ($refused as $error) {
            $this->assertStringContainsString('while the conversation is being compacted', $error);
        }

        $after = $this->requestBody(2);
        $this->assertEquals(self::compactionBlockAlone(), $after['messages']);
        $this->assertSame(2048, $after['max_tokens']);
    }

    #[Test]
    public function testMessagesCanBeChangedAgainWhenTheCompactionDoesNotComplete(): void
    {
        // The compaction request fails.
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->makeResponse(
            ['type' => 'error', 'error' => ['type' => 'invalid_request_error', 'message' => 'No.']],
            status: 400,
        ));

        $failed = $this->compactRunner();

        try {
            foreach ($failed as $_) {
                $failed->compactBeforeNextTurn();
            }
            $this->fail('The failed compaction request should have thrown');
        } catch (BadRequestException) {
        }

        // The caller leaves the loop while handling the compaction response.
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->compactedResponse());

        $abandoned = $this->compactRunner();
        foreach ($abandoned as $message) {
            if ('compaction' === $message->stopReason) {
                break;
            }
            $abandoned->compactBeforeNextTurn();
        }

        foreach ([$failed, $abandoned] as $runner) {
            $runner->pushMessages(['role' => 'user', 'content' => 'And in NYC?']);
            $this->assertCount(4, (array) $this->currentMessages($runner));
        }
    }

    // -------------------------------------------------------------------------
    // compactBeforeNextTurn(): what the runner refuses
    // -------------------------------------------------------------------------

    #[Test]
    public function testCompactionParamIsRefusedOnAToolRunner(): void
    {
        $refusal = '`compaction` cannot be set on a tool runner: every request in the loop would compact again. '
            .'Call compactBeforeNextTurn() when the conversation should be compacted instead.';

        $errors = [];
        $attempts = [
            fn () => $this->compactRunner(extraParams: ['compaction' => ['type' => 'summarize']]),
            fn () => $this->compactRunner()->setMessagesParams(['compaction' => BetaCompactionConfig::with()]),
            fn () => $this->compactRunner()->setMessagesParams(
                fn (array $params): array => ['compaction' => ['type' => 'summarize']] + $params,
            ),
        ];
        foreach ($attempts as $attempt) {
            try {
                $attempt();
            } catch (\InvalidArgumentException $e) {
                $errors[] = $e->getMessage();
            }
        }

        $this->assertSame([$refusal, $refusal, $refusal], $errors);
    }

    /**
     * @param BetaContextManagementConfig|array<string, mixed> $contextManagement
     */
    #[Test]
    #[DataProvider('compactionEdits')]
    public function testCompactBeforeNextTurnIsRefusedBesideACompactionEdit(
        BetaContextManagementConfig|array $contextManagement,
    ): void {
        $attempts = [
            fn () => $this->compactRunner(extraParams: ['contextManagement' => $contextManagement])->compactBeforeNextTurn(),
            // The edit arrives after the call was accepted, so the setter refuses it.
            function () use ($contextManagement): void {
                $runner = $this->compactRunner();
                $runner->compactBeforeNextTurn();
                $runner->setMessagesParams(['contextManagement' => $contextManagement]);
            },
        ];

        $errors = [];
        foreach ($attempts as $attempt) {
            try {
                $attempt();
            } catch (\LogicException $e) {
                $errors[] = $e->getMessage();
            }
        }

        $this->assertCount(2, $errors);
        foreach ($errors as $error) {
            $this->assertStringContainsString('has a compaction edit', $error);
        }
    }

    /**
     * @return iterable<string, array{BetaContextManagementConfig|array<string, mixed>}>
     */
    public static function compactionEdits(): iterable
    {
        yield 'array' => [['edits' => [['type' => 'clear_tool_uses_20250919'], ['type' => 'compact_20260112']]]];

        yield 'model' => [BetaContextManagementConfig::with(edits: [BetaCompact20260112Edit::with()])];

        yield 'model edit in an array' => [['edits' => [BetaCompact20260112Edit::with()]]];
    }

    #[Test]
    public function testACompactionEditMadeInPlaceIsRefusedWhenTheRequestWouldBeSent(): void
    {
        $contextManagement = BetaContextManagementConfig::with(edits: [['type' => 'clear_tool_uses_20250919']]);
        $runner = $this->compactRunner(extraParams: ['contextManagement' => $contextManagement]);
        $runner->compactBeforeNextTurn();

        // The runner holds the same object, so no setter sees this change.
        $contextManagement['edits'] = [BetaCompact20260112Edit::with()];

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('has a compaction edit');

        try {
            $runner->runUntilDone();
        } finally {
            $this->assertCount(0, $this->transporter->getRequests());
        }
    }

    // -------------------------------------------------------------------------
    // Double-consumption throws
    // -------------------------------------------------------------------------

    #[Test]
    public function testDoubleConsumptionThrows(): void
    {
        $this->transporter->setDefaultResponse($this->textResponse('Hi.'));

        $runner = $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hello']],
            model: 'claude-opus-4-6',
        );

        foreach ($runner as $_);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot iterate over a consumed runner');

        foreach ($runner as $_);
    }

    // -------------------------------------------------------------------------
    // Extra params forwarded to every API call in the loop
    // -------------------------------------------------------------------------

    #[Test]
    public function testExtraParamsForwardedToEveryApiCall(): void
    {
        $this->transporter->addResponse($this->toolUseResponse('get_weather', ['location' => 'SF']));
        $this->transporter->addResponse($this->textResponse('Sunny.'));

        foreach ($this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            extraParams: ['temperature' => 0.5, 'system' => 'You are a weather bot.'],
        ) as $_);

        foreach ($this->transporter->getRequests() as $i => $request) {
            /** @var array<string, mixed> $body */
            $body = json_decode((string) $request->getBody(), associative: true);
            $this->assertSame(0.5, $body['temperature'], "Request #{$i} missing temperature");
            $this->assertSame('You are a weather bot.', $body['system'], "Request #{$i} missing system");
        }
    }

    // -------------------------------------------------------------------------
    // Server-assigned container is forwarded to the follow-up request
    // -------------------------------------------------------------------------

    #[Test]
    public function testServerContainerForwardedToFollowUpRequest(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'SF'], container: self::CONTAINER)
        );
        $this->transporter->addResponse($this->textResponse('Sunny.'));

        $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        )->runUntilDone();

        $this->assertArrayNotHasKey('container', $this->requestBody(0));
        $this->assertSame('container_123', $this->requestBody(1)['container']);
    }

    #[Test]
    public function testResponseWithoutContainerKeySendsNoContainer(): void
    {
        $this->transporter->addResponse($this->makeResponse([
            'id' => 'msg_1',
            'type' => 'message',
            'role' => 'assistant',
            'content' => [
                ['type' => 'tool_use', 'id' => 'tool_1', 'name' => 'get_weather', 'input' => ['location' => 'SF']],
            ],
            'model' => 'claude-opus-4-6',
            'stop_reason' => 'tool_use',
            'stop_sequence' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]));
        $this->transporter->addResponse($this->textResponse('Sunny.'));

        $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
        )->runUntilDone();

        $this->assertArrayNotHasKey('container', $this->requestBody(1));
    }

    #[Test]
    public function testPinnedContainerIsNotOverridden(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'SF'], container: self::CONTAINER)
        );
        $this->transporter->addResponse($this->textResponse('Sunny.'));

        $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            extraParams: ['container' => 'container_mine'],
        )->runUntilDone();

        $this->assertSame('container_mine', $this->requestBody(1)['container']);
    }

    #[Test]
    public function testPinnedContainerParamsWithoutIdAdoptServerId(): void
    {
        $this->transporter->addResponse(
            $this->toolUseResponse('get_weather', ['location' => 'SF'], container: self::CONTAINER)
        );
        $this->transporter->addResponse($this->textResponse('Sunny.'));

        $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Weather?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            extraParams: ['container' => BetaContainerParams::with(
                skills: [['skillID' => 'pdf', 'type' => 'anthropic', 'version' => 'latest']],
            )],
        )->runUntilDone();

        $this->assertSame(
            ['id' => 'container_123', 'skills' => [['skill_id' => 'pdf', 'type' => 'anthropic', 'version' => 'latest']]],
            $this->requestBody(1)['container'],
        );
    }

    // -------------------------------------------------------------------------
    // Response fixtures
    // -------------------------------------------------------------------------

    /** @param array<string, mixed> $body */
    private function makeResponse(array $body, int $status = 200): ResponseInterface
    {
        $json = json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: '{}';

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($json))
        ;
    }

    /**
     * @param array<string, mixed> $input
     * @param array<string, mixed>|null $container
     */
    private function toolUseResponse(
        string $toolName,
        array $input,
        string $id = 'msg_1',
        string $toolId = 'tool_1',
        string $stopReason = 'tool_use',
        ?array $container = null,
    ): ResponseInterface {
        return $this->makeResponse([
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => [
                ['type' => 'tool_use', 'id' => $toolId, 'name' => $toolName, 'input' => $input],
            ],
            'model' => 'claude-opus-4-6',
            'stop_reason' => $stopReason,
            'stop_sequence' => null,
            'context_management' => null,
            'container' => $container,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]);
    }

    private function textResponse(string $text, string $id = 'msg_2'): ResponseInterface
    {
        return $this->makeResponse([
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => [['type' => 'text', 'text' => $text]],
            'model' => 'claude-opus-4-6',
            'stop_reason' => 'end_turn',
            'stop_sequence' => null,
            'context_management' => null,
            'container' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]);
    }

    private function pauseTurnResponse(string $id = 'msg_paused'): ResponseInterface
    {
        return $this->makeResponse([
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => self::PAUSED_CONTENT,
            'model' => 'claude-opus-4-6',
            'stop_reason' => 'pause_turn',
            'stop_sequence' => null,
            'context_management' => null,
            'container' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]);
    }

    private function compactionResponse(string $id = 'msg_compacted'): ResponseInterface
    {
        return $this->makeResponse([
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => self::COMPACTION_CONTENT,
            'model' => 'claude-opus-4-6',
            'stop_reason' => 'compaction',
            'stop_sequence' => null,
            'context_management' => null,
            'container' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]);
    }

    /**
     * The response to a request that carried the `compaction` param.
     *
     * @param list<array<string, mixed>>|null $content
     */
    private function compactedResponse(?array $content = null, string $stopReason = 'compaction'): ResponseInterface
    {
        return $this->makeResponse([
            'id' => 'msg_compacted',
            'type' => 'message',
            'role' => 'assistant',
            'content' => $content ?? self::compactionBlockAlone()[0]['content'],
            'model' => 'claude-opus-4-6',
            'stop_reason' => $stopReason,
            'stop_sequence' => null,
            'context_management' => null,
            'container' => null,
            'usage' => ['input_tokens' => 10, 'output_tokens' => 20],
        ]);
    }

    /**
     * @return list<array{role: string, content: list<array<string, mixed>>}>
     */
    private static function compactionBlockAlone(): array
    {
        return [[
            'role' => 'assistant',
            'content' => [['type' => 'compaction', 'content' => 'Summary so far.', 'signature' => 'sig_01']],
        ]];
    }

    // -------------------------------------------------------------------------
    // Runner fixtures
    // -------------------------------------------------------------------------

    /**
     * @param array<string, mixed> $extraParams
     */
    private function compactRunner(?int $maxIterations = null, array $extraParams = []): BetaToolRunner
    {
        return $this->client->beta->messages->toolRunner(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'What is the weather in SF?']],
            model: 'claude-opus-4-6',
            tools: [$this->makeWeatherTool()],
            maxIterations: $maxIterations,
            extraParams: $extraParams,
        );
    }

    /**
     * The runner's message history in its API shape.
     */
    private function currentMessages(BetaToolRunner $runner): mixed
    {
        return json_decode(
            json_encode($runner->getParams()['messages'], flags: Util::JSON_ENCODE_FLAGS),
            associative: true,
        );
    }

    /**
     * Runs the callback and returns the E_USER_WARNING messages it raised.
     *
     * @return list<string>
     */
    private function captureWarnings(\Closure $run): array
    {
        $warnings = [];
        set_error_handler(
            function (int $_, string $message) use (&$warnings): bool {
                $warnings[] = $message;

                return true;
            },
            E_USER_WARNING,
        );

        try {
            $run();
        } finally {
            restore_error_handler();
        }

        return $warnings;
    }

    // -------------------------------------------------------------------------
    // Tool fixtures
    // -------------------------------------------------------------------------

    private function makeWeatherTool(?\Closure $run = null): BetaRunnableTool
    {
        return new BetaRunnableTool(
            definition: [
                'name' => 'get_weather',
                'description' => 'Get weather for a location',
                'input_schema' => [
                    'type' => 'object',
                    'properties' => ['location' => ['type' => 'string']],
                    'required' => ['location'],
                ],
            ],
            run: /**
                  * @param array<string, mixed> $input
                  */
                function (array $input) use ($run): string {
                    if (null !== $run) {
                        ($run)($input);
                    }

                    return json_encode(['location' => $input['location'] ?? '', 'temperature' => 72]) ?: '';
                },
        );
    }

    /**
     * Returns the first content block of the last message in a request body.
     *
     * @param array<string, mixed> $body
     *
     * @return array<string, mixed>
     */
    private function lastToolResult(array $body): array
    {
        /** @var list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        /** @var array<string, mixed> $lastMsg */
        $lastMsg = end($messages);

        /** @var list<array<string, mixed>> $content */
        $content = $lastMsg['content'];

        return $content[0];
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return array<string, mixed>
     */
    private function lastMessage(array $body): array
    {
        /** @var non-empty-list<array<string, mixed>> $messages */
        $messages = $body['messages'];

        return $messages[array_key_last($messages)];
    }

    /**
     * Returns the decoded body of every request sent.
     *
     * @return list<array<string, mixed>>
     */
    private function requestBodies(): array
    {
        return array_map(
            fn (int $index) => $this->requestBody($index),
            array_keys($this->transporter->getRequests()),
        );
    }

    /**
     * Returns the decoded body of the nth request (0-indexed).
     *
     * @return array<string, mixed>
     */
    private function requestBody(int $index = 0): array
    {
        $requests = $this->transporter->getRequests();
        $this->assertArrayHasKey($index, $requests, "Expected request #{$index} to exist");

        /** @var array<string, mixed> */
        return json_decode((string) $requests[$index]->getBody(), associative: true);
    }
}
