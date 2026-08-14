<?php

declare(strict_types=1);

namespace Tests\Lib\Tools;

use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
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
    // Refusal-terminated turn is final even when it carries a tool_use block
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
    private function makeResponse(array $body): ResponseInterface
    {
        $json = json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: '{}';

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
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
