<?php

declare(strict_types=1);

namespace Tests\Lib\Tools;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaTextBlock;
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

    /** @param array<string, mixed> $input */
    private function toolUseResponse(
        string $toolName,
        array $input,
        string $id = 'msg_1',
        string $toolId = 'tool_1',
    ): ResponseInterface {
        return $this->makeResponse([
            'id' => $id,
            'type' => 'message',
            'role' => 'assistant',
            'content' => [
                ['type' => 'tool_use', 'id' => $toolId, 'name' => $toolName, 'input' => $input],
            ],
            'model' => 'claude-opus-4-6',
            'stop_reason' => 'tool_use',
            'stop_sequence' => null,
            'context_management' => null,
            'container' => null,
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
