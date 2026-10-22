<?php

declare(strict_types=1);

namespace Tests\Lib\Tools;

use Anthropic\Client;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Lib\Threads\BetaMessageThread;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Anthropic\Lib\Tools\BetaToolRunner;
use Anthropic\RequestOptions;
use Http\Mock\Client as MockClient;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Lib\Threads\MocksThreadRequests;

/**
 * The tool runner on a message thread.
 *
 * @internal
 *
 * @coversNothing
 */
final class BetaToolRunnerThreadsTest extends TestCase
{
    use MocksThreadRequests;

    private const THREADS_BETA = 'message-threads-2026-08-12';

    private const ASK = ['role' => 'user', 'content' => 'Weather in SF?'];

    private const MORE = ['role' => 'user', 'content' => 'And in NYC?'];

    private const TOOL = ['name' => 'get_weather', 'input_schema' => ['type' => 'object']];

    private const CREATE = ['type' => 'create'];

    private const SUMMARY = ['role' => 'assistant', 'content' => [['type' => 'compaction', 'content' => 'The user asked about the weather.']]];

    private const TOOL_CHANGES_BETA = 'inline-tools-2026-09-15';

    private const LOOKUP_ADDED = ['role' => 'system', 'content' => [['type' => 'tool_addition', 'tool' => ['type' => 'tool_definition', 'definition' => ['name' => 'lookup', 'input_schema' => ['type' => 'object']]]]]];

    private const WEATHER_REMOVED = ['role' => 'system', 'content' => [['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']]]];

    /** @var list<string> the ids of the tool calls that were run */
    private array $ran = [];

    #[Test]
    public function testTheRunnerUsesAThreadByDefault(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $final = $this->runner(extraParams: ['system' => 'Be brief.'])->runUntilDone();

        $this->assertSame('msg_2', $final->id);
        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::ASK],
                'model' => 'claude-opus-4-6',
                'system' => 'Be brief.',
                'thread' => self::CREATE,
                'tools' => [self::TOOL],
            ],
            $this->body(0),
        );
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::results('toolu_1')],
                'model' => 'claude-opus-4-6',
                'thread' => self::continues('msg_1'),
            ],
            $this->body(1),
        );
        $this->assertSame([[self::THREADS_BETA], [self::THREADS_BETA]], [$this->betas(0), $this->betas(1)]);
        $this->assertSame(['BetaToolRunner, message-thread', 'BetaToolRunner, message-thread'], $this->helperHeaders());
    }

    #[Test]
    public function testThreadFalseOptsOut(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $this->client->beta->messages->toolRunner(
            maxTokens: 64,
            messages: [self::ASK],
            model: 'claude-opus-4-6',
            tools: [$this->tool()],
            thread: false,
        )->runUntilDone();

        foreach ([0, 1] as $index) {
            $this->assertArrayNotHasKey('thread', $this->body($index));
            $this->assertSame([], $this->betas($index));
            $this->assertSame([self::TOOL], $this->body($index)['tools']);
        }
        $this->assertSame([self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')], $this->body(1)['messages']);
        $this->assertSame(['BetaToolRunner', 'BetaToolRunner'], $this->helperHeaders());
    }

    /**
     * @param RequestOptions|array<string, mixed> $requestOptions
     */
    #[Test]
    #[DataProvider('requestOptionsForms')]
    public function testRequestOptionsAmongTheExtraParamsReachEveryRequestOfTheThread(RequestOptions|array $requestOptions): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::compacted(), self::says('msg_2', 'Sunny.'));

        $runner = $this->runner(extraParams: ['betas' => ['compact-2026-09-04'], 'requestOptions' => $requestOptions]);
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertCount(3, $this->transporter->getRequests());
        foreach ([0, 1, 2] as $index) {
            $this->assertSame('kept', $this->request($index)->getHeaderLine('x-custom-header'));
            $this->assertSame(['my-wrapper, BetaToolRunner, message-thread'], $this->request($index)->getHeader('x-stainless-helper'));
            $this->assertArrayNotHasKey('requestOptions', $this->body($index));
        }
    }

    /**
     * @return iterable<string, array{RequestOptions|array<string, mixed>}>
     */
    public static function requestOptionsForms(): iterable
    {
        $extraHeaders = ['X-Stainless-Helper' => 'my-wrapper', 'x-custom-header' => 'kept'];

        yield 'an array' => [['extraHeaders' => $extraHeaders]];

        yield 'an object' => [RequestOptions::with(extraHeaders: $extraHeaders)];
    }

    /**
     * @param array<string, mixed> $value
     */
    #[Test]
    #[DataProvider('threadValues')]
    public function testAThreadValueOfTheCallerIsRefused(array $value): void
    {
        $routes = [fn () => $this->runner(thread: $value)];
        foreach ([false, null] as $thread) {
            $runner = $this->runner(thread: $thread);
            $routes[] = fn () => $this->runner(extraParams: ['thread' => $value], thread: $thread);
            $routes[] = static fn () => $runner->setMessagesParams(['thread' => $value]);
            $routes[] = static fn () => $runner->setMessagesParams(static fn (array $params) => ['thread' => $value] + $params);
        }

        foreach ($routes as $route) {
            $error = $this->assertThrows(\InvalidArgumentException::class, $route);
            $this->assertStringStartsWith('`thread` cannot be set on a tool runner: ', $error->getMessage());
        }

        $this->assertSame([], $this->transporter->getRequests());
        $this->assertSame([], $this->ran);
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function threadValues(): iterable
    {
        yield 'create' => [['type' => 'create']];

        yield 'continue' => [['type' => 'continue', 'previousMessageID' => 'msg_0']];
    }

    /**
     * @param \Closure(MockClient): Client $factory
     */
    #[Test]
    #[DataProvider('platformClients')]
    public function testAThreadValueOfTheCallerIsRefusedOnEveryPlatform(\Closure $factory): void
    {
        $messages = $factory($this->transporter)->beta->messages;
        $runner = $messages->toolRunner(maxTokens: 64, messages: [self::ASK], model: 'claude-opus-4-6');

        foreach ([
            static fn () => $messages->toolRunner(maxTokens: 64, messages: [self::ASK], model: 'claude-opus-4-6', extraParams: ['thread' => self::CREATE]),
            static fn () => $runner->setMessagesParams(['thread' => self::CREATE]),
        ] as $route) {
            $error = $this->assertThrows(\InvalidArgumentException::class, $route);
            $this->assertStringStartsWith('`thread` cannot be set on a tool runner: ', $error->getMessage());
        }

        $this->assertSame([], $this->transporter->getRequests());
    }

    #[Test]
    public function testANullThreadInTheParamsCountsAsUnset(): void
    {
        $this->respond(self::says('msg_1', 'Sunny.'), self::says('msg_2', 'Sunny.'));

        foreach ([null, false] as $thread) {
            $runner = $this->runner(extraParams: ['thread' => null], thread: $thread);
            $runner->setMessagesParams(['thread' => null]);
            $runner->runUntilDone();
        }

        $this->assertSame(self::CREATE, $this->body(0)['thread']);
        $this->assertArrayNotHasKey('thread', $this->body(1));
    }

    // -------------------------------------------------------------------------
    // Messages and params that the caller changes
    // -------------------------------------------------------------------------

    #[Test]
    public function testAMessageAddedWhileHandlingAReplyGoesOutAfterTheToolResults(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::calls('msg_2', 'toolu_2'), self::says('msg_3', 'Sunny.'));
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()]);

        $runner = $thread->toolRunner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->pushMessages(self::MORE);
            } elseif ('msg_2' === $message->id) {
                $thread->append(self::MORE);
            }
        }

        $this->assertSame([self::results('toolu_1'), self::MORE], $this->body(1)['messages']);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertSame([self::results('toolu_2'), self::MORE], $this->body(2)['messages']);
        $this->assertSame(self::continues('msg_2'), $this->body(2)['thread']);
        $this->assertSame(
            [
                self::ASK,
                self::toolUse('toolu_1'),
                self::results('toolu_1'),
                self::MORE,
                self::toolUse('toolu_2'),
                self::results('toolu_2'),
                self::MORE,
                self::text('Sunny.'),
            ],
            $this->wire($thread->messages()),
        );
    }

    #[Test]
    public function testAMessageAppendedToTheThreadByAToolGoesOutAfterTheToolResults(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        /** @var BetaMessageThread|null $thread */
        $thread = null;
        $tool = new BetaRunnableTool(self::TOOL, static function () use (&$thread): string {
            $thread?->append(self::MORE);

            return 'ran';
        });
        $thread = $this->newThread(messages: [self::ASK], tools: [$tool]);

        $thread->toolRunner()->runUntilDone();

        $this->assertSame([self::continues('msg_1'), [self::results('toolu_1'), self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertSame(
            [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1'), self::MORE, self::text('Sunny.')],
            $this->wire($thread->messages()),
        );
    }

    #[Test]
    public function testToolResultsComeFirstWhenTheWholeHistoryIsSentAgain(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::error(404, ['error_code' => 'thread_not_found']),
            self::calls('msg_2', 'toolu_2'),
            self::error(400, ['error_code' => 'thread_unsupported_request']),
            self::says('msg_3', 'Sunny.'),
        );

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('tool_use' === $message->stopReason) {
                $runner->pushMessages(self::MORE);
            }
        }

        $first = [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1'), self::MORE];
        $this->assertSame([self::results('toolu_1'), self::MORE], $this->body(1)['messages']);
        $this->assertSame(self::CREATE, $this->body(2)['thread']);
        $this->assertSame($first, $this->body(2)['messages']);
        $this->assertSame([self::results('toolu_2'), self::MORE], $this->body(3)['messages']);
        $this->assertArrayNotHasKey('thread', $this->body(4));
        $this->assertSame([...$first, self::toolUse('toolu_2'), self::results('toolu_2'), self::MORE], $this->body(4)['messages']);
        $this->assertSame(['toolu_1', 'toolu_2'], $this->ran);
    }

    #[Test]
    public function testAHistoryThatIsRewrittenStartsANewThread(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::calls('msg_2', 'toolu_2'), self::says('msg_3', 'Sunny.'));

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['messages' => [self::MORE]]);
            }
        }

        $this->assertSame(['toolu_2'], $this->ran, 'A reply that left the history is not answered');
        $this->assertSame(self::CREATE, $this->body(1)['thread']);
        $this->assertSame([self::MORE], $this->body(1)['messages']);
        $this->assertSame([self::TOOL], $this->body(1)['tools']);
        $this->assertSame(self::continues('msg_2'), $this->body(2)['thread']);
        $this->assertSame([self::results('toolu_2')], $this->body(2)['messages']);
    }

    #[Test]
    public function testAHistoryRewrittenToKeepTheReplyAnswersIt(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['messages' => [self::MORE, $message, self::ASK]]);
            }
        }

        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame(self::CREATE, $this->body(1)['thread']);
        $this->assertSame([self::MORE, self::toolUse('toolu_1'), self::results('toolu_1'), self::ASK], $this->body(1)['messages']);
        $this->assertSame(
            [self::MORE, self::toolUse('toolu_1'), self::results('toolu_1'), self::ASK, self::text('Sunny.')],
            $this->wire($runner->getParams()['messages']),
        );
    }

    #[Test]
    public function testParamsSetInPartKeepTheRest(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $runner = $this->runner(extraParams: ['stopSequences' => ['END'], 'serviceTier' => 'auto']);
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['maxTokens' => 128, 'serviceTier' => null]);
            }
        }

        $this->assertSame(
            [
                'max_tokens' => 128,
                'messages' => [self::results('toolu_1')],
                'model' => 'claude-opus-4-6',
                'stop_sequences' => ['END'],
                'thread' => self::continues('msg_1'),
            ],
            $this->body(1),
        );
        $this->assertSame(128, $runner->getParams()['maxTokens']);
        $this->assertArrayNotHasKey('serviceTier', $runner->getParams());
    }

    /**
     * @param array<string, mixed> $changed
     */
    #[Test]
    #[DataProvider('refusedChanges')]
    public function testAChangedSystemOrToolsEndsTheRunBeforeAToolRunsOrARequestIsSent(string $field, array $changed): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));
        $runner = $this->runner();

        $e = $this->assertThrows(\LogicException::class, static function () use ($runner, $changed): void {
            foreach ($runner as $_) {
                $runner->setMessagesParams($changed);
            }
        });

        $this->assertStringStartsWith("Cannot change `{$field}` on a thread:", $e->getMessage());
        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame([], $this->ran);
    }

    /**
     * @return iterable<string, array{string, array<string, mixed>}>
     */
    public static function refusedChanges(): iterable
    {
        yield 'system' => ['system', ['system' => 'Be brief.']];

        yield 'tools' => ['tools', ['tools' => []]];
    }

    #[Test]
    public function testAPausedTurnIsResumedWithNoMessages(): void
    {
        $this->respond(self::says('msg_1', 'Searching', 'pause_turn'), self::says('msg_2', 'Sunny.'));

        $this->runner()->runUntilDone();

        $this->assertSame([self::continues('msg_1'), []], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    #[Test]
    public function testAMessageAppendedToTheThreadWhileATurnIsPausedIsSentWithTheResumeAndKeptWhenItFails(): void
    {
        $this->respond(self::says('msg_1', 'Searching', 'pause_turn'), self::error(400));
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()]);

        $this->assertThrows(BadRequestException::class, static function () use ($thread): void {
            foreach ($thread->toolRunner() as $_) {
                $thread->append(self::MORE);
            }
        });

        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertSame([self::ASK, self::text('Searching'), self::MORE], $this->wire($thread->messages()));
    }

    #[Test]
    public function testParamsSetWhileATurnIsPausedAddNoTurnAfterTheFinalReply(): void
    {
        $this->respond(self::says('msg_1', 'Searching', 'pause_turn'), self::says('msg_2', 'Sunny.'));

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['maxTokens' => 128]);
            }
        }

        $this->assertCount(2, $this->transporter->getRequests());
    }

    #[Test]
    public function testAHistoryRewrittenWhileATurnIsPausedIsSentWhole(): void
    {
        $this->respond(self::says('msg_1', 'Searching', 'pause_turn'), self::says('msg_2', 'Rainy.'));

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['messages' => [self::MORE]]);
            }
        }

        $this->assertSame([self::CREATE, [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    #[Test]
    public function testAToolChangeIsSentInTheMessagesAfterTheToolResults(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $runner = $this->runner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->removeTools('get_time');
            }
        }

        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertArrayNotHasKey('tools', $this->body(1));
        $this->assertSame(
            [self::results('toolu_1'), ['role' => 'system', 'content' => [['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_time']]]]],
            $this->body(1)['messages'],
        );
    }

    #[Test]
    public function testToolsAddedAndRemovedDuringARunGoOutOnTheThread(): void
    {
        $this->respond(...self::repliesThatCallChangedTools());

        $final = $this->changeToolsDuring($this->runner(extraParams: ['betas' => [self::TOOL_CHANGES_BETA]]));

        $this->assertSame('msg_4', $final);
        $this->assertSame(['toolu_1', 'toolu_2'], $this->ran);
        $this->assertCount(4, $this->transporter->getRequests());
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::ASK], 'model' => 'claude-opus-4-6', 'thread' => self::CREATE, 'tools' => [self::TOOL]],
            $this->body(0),
        );
        $this->assertToolChangesContinueTheThread(1);
    }

    #[Test]
    public function testAMessageAddedAfterTheFinalReplyIsAnotherTurn(): void
    {
        $this->respond(self::says('msg_1', 'Sunny.'), self::says('msg_2', 'Rainy.'));

        $runner = $this->runner();
        $replies = [];
        foreach ($runner as $message) {
            $replies[] = $message->id;
            if ('msg_1' === $message->id) {
                $runner->pushMessages(self::MORE);
            }
        }

        $this->assertSame(['msg_1', 'msg_2'], $replies);
        $this->assertSame([self::MORE], $this->body(1)['messages']);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
    }

    // -------------------------------------------------------------------------
    // A runner over a thread
    // -------------------------------------------------------------------------

    #[Test]
    public function testARunnerOverAThreadContinuesIt(): void
    {
        $this->respond(self::says('msg_1', 'Hello.'), self::calls('msg_2', 'toolu_1'), self::says('msg_3', 'Sunny.'), self::says('msg_4', 'Rainy.'));
        $thread = $this->newThread(
            system: 'Be brief.',
            tools: [$this->tool()],
            requestOptions: ['extraHeaders' => ['X-One' => 'creation']],
        );
        $thread->send(['role' => 'user', 'content' => 'Hello']);
        $thread->append(self::ASK);

        $runner = $thread->toolRunner();
        $this->assertCount(1, $this->transporter->getRequests());
        $final = $runner->runUntilDone();
        $thread->send(self::MORE);

        $this->assertSame('msg_3', $final->id);
        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::ASK], 'model' => 'claude-opus-4-6', 'thread' => self::continues('msg_1')],
            $this->body(1),
        );
        $this->assertSame([self::results('toolu_1')], $this->body(2)['messages']);
        $this->assertSame(self::continues('msg_3'), $this->body(3)['thread']);
        $this->assertCount(8, $thread->messages());
        $this->assertSame($this->wire($thread->messages()), $this->wire($runner->getParams()['messages']));
        foreach ([0, 1, 2, 3] as $index) {
            $this->assertSame('creation', $this->request($index)->getHeaderLine('X-One'));
        }
        $this->assertSame(['message-thread', 'BetaToolRunner, message-thread', 'BetaToolRunner, message-thread', 'message-thread'], $this->helperHeaders());
    }

    #[Test]
    public function testTheSpansOfARunnerOverAThreadDescribeTheThread(): void
    {
        $exporter = new InMemoryExporter;
        $this->client = new Client(
            apiKey: 'test-api-key',
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0],
            openTelemetry: ['tracerProvider' => new TracerProvider(new SimpleSpanProcessor($exporter))],
        );
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $this->newThread(
            messages: [self::ASK],
            tools: [$this->tool()],
            outputConfig: ['format' => ['type' => 'json_schema', 'schema' => ['type' => 'object']]],
            requestOptions: ['openTelemetry' => ['conversationId' => 'conv_thread']],
        )->toolRunner()->runUntilDone();

        $conversations = [];
        $toolRunnerSpan = null;
        foreach ($exporter->getSpans() as $span) {
            $this->assertInstanceOf(SpanDataInterface::class, $span);
            $conversations[$span->getName()][] = $span->getAttributes()->get('gen_ai.conversation.id');
            if ('anthropic.messages.tool_runner' === $span->getName()) {
                $toolRunnerSpan = $span;
            }
        }
        ksort($conversations);

        $this->assertSame(
            [
                'anthropic.custom_tool_use get_weather' => ['conv_thread'],
                'anthropic.messages.create' => ['conv_thread', 'conv_thread'],
                'anthropic.messages.tool_runner' => ['conv_thread'],
            ],
            $conversations,
        );
        $this->assertNotNull($toolRunnerSpan);
        $this->assertSame('claude-opus-4-6', $toolRunnerSpan->getAttributes()->get('gen_ai.request.model'));
        $this->assertSame('json', $toolRunnerSpan->getAttributes()->get('gen_ai.output.type'));
    }

    #[Test]
    public function testARunnerOverAForkRunsTheToolsOfTheThread(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $this->thread()->fork()->toolRunner()->runUntilDone();

        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame([self::TOOL], $this->body(0)['tools']);
        $this->assertSame([self::continues('msg_1'), [self::results('toolu_1')]], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    #[Test]
    public function testAToolAddedOnARunnerStaysWithThatRunner(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1', name: 'get_time'),
            self::says('msg_2', 'Noon.'),
            self::calls('msg_3', 'toolu_2', name: 'get_time'),
            self::says('msg_4', 'Noon.'),
        );
        $thread = $this->thread();

        $runner = $thread->toolRunner();
        $runner->addTools($this->tool('get_time'));
        $runner->runUntilDone();
        $thread->append(self::MORE);
        $thread->toolRunner()->runUntilDone();

        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame(
            [['role' => 'user', 'content' => [['type' => 'tool_result', 'tool_use_id' => 'toolu_2', 'content' => "Error: Tool 'get_time' not found", 'is_error' => true]]]],
            $this->body(3)['messages'],
        );
    }

    #[Test]
    public function testToolsAddedAndRemovedOnARunnerOverAThreadStayInItsHistory(): void
    {
        $this->respond(self::says('msg_0', 'Hello.'), ...self::repliesThatCallChangedTools());
        $this->respond(self::says('msg_5', 'Rainy.'));
        $thread = $this->newThread(tools: [$this->tool()], betas: [self::TOOL_CHANGES_BETA]);
        $thread->send(['role' => 'user', 'content' => 'Hello']);
        $thread->append(self::ASK);

        $this->changeToolsDuring($thread->toolRunner());
        $thread->send(self::MORE);

        $this->assertSame(['toolu_1', 'toolu_2'], $this->ran);
        $this->assertCount(6, $this->transporter->getRequests());
        $this->assertSame([self::TOOL], $this->body(0)['tools']);
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::ASK], 'model' => 'claude-opus-4-6', 'thread' => self::continues('msg_0')],
            $this->body(1),
        );
        $this->assertToolChangesContinueTheThread(2);
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::MORE], 'model' => 'claude-opus-4-6', 'thread' => self::continues('msg_4')],
            $this->body(5),
        );
        $this->assertSame(
            [self::LOOKUP_ADDED, self::WEATHER_REMOVED],
            array_values(array_filter($this->wire($thread->messages()), static fn (mixed $message) => is_array($message) && 'system' === $message['role'])),
        );
    }

    #[Test]
    public function testARunnerOverAThreadThatCompactsEveryRequestIsALocalError(): void
    {
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()], compaction: ['type' => 'summarize']);

        $e = $this->assertThrows(\InvalidArgumentException::class, static fn () => $thread->toolRunner());
        $this->assertStringContainsString('compactBeforeNextTurn()', $e->getMessage());

        $this->assertSame([], $this->transporter->getRequests());
        $this->assertSame([self::ASK], $thread->messages());
    }

    #[Test]
    public function testACompactionSetOnTheThreadDuringTheRunIsALocalError(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()]);

        $seen = [];

        try {
            foreach ($thread->toolRunner() as $message) {
                $seen[] = $message->id;
                $thread->update(['compaction' => ['type' => 'summarize']]);
            }
            $this->fail('Expected an InvalidArgumentException');
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('compactBeforeNextTurn()', $e->getMessage());
        }

        $this->assertSame(['msg_1'], $seen);
        $this->assertSame([], $this->ran);
        $this->assertCount(1, $this->transporter->getRequests());
    }

    #[Test]
    public function testARunnerOverAThreadUsesItsUnsupportedRequestBehavior(): void
    {
        $unsupported = self::error(400, ['error_code' => 'thread_unsupported_request']);
        $this->respond($unsupported, $unsupported, self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $this->assertThrows(BadRequestException::class, fn () => $this->newThread(messages: [self::ASK], tools: [$this->tool()])->toolRunner()->runUntilDone());
        $this->assertCount(1, $this->transporter->getRequests());

        $final = $this->newThread(messages: [self::ASK], tools: [$this->tool()], unsupportedRequestBehavior: 'continue_unthreaded')->toolRunner()->runUntilDone();

        $this->assertSame('msg_2', $final->id);
        $this->assertArrayNotHasKey('thread', $this->body(3));
        $this->assertCount(3, (array) $this->body(3)['messages']);
    }

    #[Test]
    public function testARunEndsOnARefusalAndItsToolResultsStayStaged(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'No.', 'refusal'), self::says('msg_3', 'Rainy.'));
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()]);

        $runner = $thread->toolRunner();
        $final = $runner->runUntilDone();
        $this->assertSame([self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')], $this->wire($runner->getParams()['messages']));
        $thread->send(self::MORE);

        $this->assertSame(['msg_2', 'refusal'], [$final->id, $final->stopReason]);
        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame([self::continues('msg_1'), [self::results('toolu_1')]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1'), self::MORE],
                'model' => 'claude-opus-4-6',
                'thread' => self::CREATE,
                'tools' => [self::TOOL],
            ],
            $this->body(2),
        );
    }

    #[Test]
    public function testARunGoesOnUnderANewThreadAfterAFallbackModelAnsweredIt(): void
    {
        $fallbacks = [['model' => 'claude-sonnet-4-6']];
        $call = self::message('msg_1', [['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['call' => 'toolu_1']]], 'tool_use');
        $this->respond(
            self::json(200, ['usage' => self::usageOfAFallbackTo('claude-sonnet-4-6')] + $call),
            self::calls('msg_2', 'toolu_2'),
            self::says('msg_3', 'Sunny.'),
        );

        $runner = $this->runner(extraParams: ['fallbacks' => $fallbacks]);
        $final = $runner->runUntilDone();

        $this->assertSame('msg_3', $final->id);
        $this->assertSame(['claude-opus-4-6', $fallbacks], [$runner->getParams()['model'], $runner->getParams()['fallbacks']]);
        $this->assertSame(['toolu_1', 'toolu_2'], $this->ran);
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')],
                'model' => 'claude-opus-4-6',
                'fallbacks' => $fallbacks,
                'thread' => self::CREATE,
                'tools' => [self::TOOL],
            ],
            $this->body(1),
        );
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::results('toolu_2')], 'model' => 'claude-opus-4-6', 'fallbacks' => $fallbacks, 'thread' => self::continues('msg_2')],
            $this->body(2),
        );
    }

    #[Test]
    public function testARunGoesOnWithoutAThreadWhenTheThreadThatReplacedALostOneIsNotFoundEither(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::error(404, ['error_code' => 'thread_not_found']),
            self::calls('msg_2', 'toolu_2'),
            self::error(404, ['error_code' => 'thread_not_found']),
            self::calls('msg_3', 'toolu_3'),
            self::says('msg_4', 'Sunny.'),
        );

        $final = $this->runner()->runUntilDone();

        $history = [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1'), self::toolUse('toolu_2'), self::results('toolu_2')];
        $this->assertSame('msg_4', $final->id);
        $this->assertSame(['toolu_1', 'toolu_2', 'toolu_3'], $this->ran);
        $this->assertSame([self::CREATE, self::continues('msg_1'), self::CREATE, self::continues('msg_2'), null, null], $this->threads());
        $this->assertSame([$history, [self::TOOL]], [$this->body(4)['messages'], $this->body(4)['tools']]);
        $this->assertSame([...$history, self::toolUse('toolu_3'), self::results('toolu_3')], $this->body(5)['messages']);
    }

    #[Test]
    public function testARunnerWithoutAThreadKeepsARefusedReplyAndEveryCacheBreakpoint(): void
    {
        $marked = ['role' => 'user', 'content' => [['type' => 'text', 'text' => 'Weather in SF?', 'cache_control' => ['type' => 'ephemeral']]]];
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'No.', 'refusal'));
        $runner = $this->client->beta->messages->toolRunner(maxTokens: 64, messages: [$marked], model: 'claude-opus-4-6', tools: [$this->tool()], thread: false);

        $runner->runUntilDone();

        $this->assertSame([$marked, self::toolUse('toolu_1'), self::results('toolu_1')], $this->body(1)['messages']);
        $this->assertSame([$marked, self::toolUse('toolu_1'), self::results('toolu_1'), self::text('No.')], $this->wire($runner->getParams()['messages']));
    }

    // -------------------------------------------------------------------------
    // Compaction
    // -------------------------------------------------------------------------

    #[Test]
    public function testACompactionIsARequestOfItsOwnAndReplacesTheHistory(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::compacted(),
            self::says('msg_2', 'Sunny.'),
            self::says('msg_3', 'Rainy.'),
        );
        $thread = $this->newThread(messages: [self::ASK], tools: [$this->tool()], stopSequences: ['END'], betas: ['compact-2026-09-04']);

        $runner = $thread->toolRunner();
        $replies = [];
        foreach ($runner as $key => $message) {
            $this->assertSame(count($replies), $key);
            $replies[] = $message->id;
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            } elseif ('msg_compacted' === $message->id) {
                $this->assertThrows(\LogicException::class, static fn () => $runner->pushMessages(self::MORE));
            }
        }
        $thread->send(self::MORE);

        $this->assertSame(['msg_1', 'msg_compacted', 'msg_2'], $replies);
        $this->assertSame(['toolu_1'], $this->ran);
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')],
                'model' => 'claude-opus-4-6',
                'compaction' => ['type' => 'summarize'],
                'thread' => self::CREATE,
                'tools' => [self::TOOL],
            ],
            $this->body(1),
        );
        $this->assertEqualsCanonicalizing(['compact-2026-09-04', self::THREADS_BETA], $this->betas(1));
        $this->assertSame(self::CREATE, $this->body(2)['thread']);
        $this->assertSame([self::SUMMARY], $this->body(2)['messages']);
        $this->assertSame(['END'], $this->body(2)['stop_sequences']);
        $this->assertSame(self::continues('msg_2'), $this->body(3)['thread']);
        $this->assertSame([...array_fill(0, 3, 'BetaToolRunner, message-thread'), 'message-thread'], $this->helperHeaders());
    }

    #[Test]
    #[DataProvider('turnsBeforeACompaction')]
    public function testAMessageAppendedToTheThreadWhileTheRunnerCompactsIsSentAfterTheCompaction(ResponseInterface $turn, bool $runGoesOn): void
    {
        $this->respond($turn, self::compacted(), self::says('msg_2', 'Rainy.'));
        $thread = $this->thread();

        $runner = $thread->toolRunner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            } elseif ('msg_compacted' === $message->id) {
                $thread->append(self::MORE);
            }
        }
        if (!$runGoesOn) {
            $this->assertCount(2, $this->transporter->getRequests());
            $this->assertSame([self::SUMMARY, self::MORE], $this->wire($thread->messages()));
            $thread->send();
        }

        $this->assertCount(3, $this->transporter->getRequests());
        $this->assertNotContains(self::MORE, (array) $this->body(1)['messages']);
        $this->assertSame([self::CREATE, [self::SUMMARY, self::MORE]], [$this->body(2)['thread'], $this->body(2)['messages']]);
        $this->assertSame([self::SUMMARY, self::MORE, self::text('Rainy.')], $this->wire($thread->messages()));
    }

    /**
     * @return iterable<string, array{ResponseInterface, bool}> the reply before the compaction, and whether the runner sends another turn after it
     */
    public static function turnsBeforeACompaction(): iterable
    {
        yield 'a turn that calls a tool' => [self::calls('msg_1', 'toolu_1'), true];

        yield 'the final turn' => [self::says('msg_1', 'Sunny.'), false];
    }

    #[Test]
    #[DataProvider('runnersWithAndWithoutAThread')]
    public function testAMessagePushedWhileTheCompactionRequestIsSentGoesOutAfterTheCompaction(bool $threaded): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::compacted(), self::says('msg_2', 'Rainy.'));

        /** @var BetaToolRunner|null $runner */
        $runner = null;
        $push = static function (RequestInterface $request, callable $next) use (&$runner) {
            if (str_contains((string) $request->getBody(), '"compaction":')) {
                $runner?->pushMessages(self::MORE);
            }

            return $next($request);
        };
        $runner = $this->runner(extraParams: ['betas' => ['compact-2026-09-04'], 'requestOptions' => ['middleware' => [$push]]], thread: $threaded ? null : false);

        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertNotContains(self::MORE, (array) $this->body(1)['messages']);
        $this->assertSame([self::SUMMARY, self::MORE], $this->body(2)['messages']);
    }

    /**
     * @return iterable<string, array{bool}>
     */
    public static function runnersWithAndWithoutAThread(): iterable
    {
        yield 'on a thread' => [true];

        yield 'without a thread' => [false];
    }

    #[Test]
    public function testTheCompactionResponseAppendedToTheThreadIsSentOnce(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::compacted(), self::says('msg_2', 'Rainy.'));
        $thread = $this->thread();

        $runner = $thread->toolRunner();
        foreach ($runner as $message) {
            $thread->append($message);
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertSame([self::SUMMARY], $this->body(2)['messages']);
        $this->assertSame([self::SUMMARY, self::text('Rainy.')], $this->wire($thread->messages()));
    }

    #[Test]
    public function testACompactionThatCannotUseAThreadCostsOneRejectedRequest(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::error(400, ['error_code' => 'thread_unsupported_request', 'unsupported' => ['context_management']]),
            self::compacted(),
            self::calls('msg_2', 'toolu_2'),
            self::says('msg_3', 'Rainy.'),
        );
        $before = [self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')];

        $runner = $this->runner(extraParams: ['betas' => ['compact-2026-09-04']]);
        $replies = [];
        foreach ($runner as $message) {
            $replies[] = $message->id;
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            }
        }

        $this->assertSame(['msg_1', 'msg_compacted', 'msg_2', 'msg_3'], $replies);
        $this->assertCount(5, $this->transporter->getRequests(), 'One request was rejected');
        $this->assertSame([self::CREATE, ['type' => 'summarize'], $before], [$this->body(1)['thread'], $this->body(1)['compaction'], $this->body(1)['messages']]);
        $this->assertContains(self::THREADS_BETA, $this->betas(1));
        $this->assertSame([['type' => 'summarize'], $before], [$this->body(2)['compaction'], $this->body(2)['messages']]);
        $this->assertSame([self::SUMMARY], $this->body(3)['messages']);
        $this->assertSame([self::SUMMARY, self::toolUse('toolu_2'), self::results('toolu_2')], $this->body(4)['messages']);
        foreach ([2, 3, 4] as $index) {
            $this->assertArrayNotHasKey('thread', $this->body($index));
            $this->assertSame(['compact-2026-09-04'], $this->betas($index));
            $this->assertSame([self::TOOL], $this->body($index)['tools']);
        }
    }

    #[Test]
    public function testARefusedCompactionLeavesTheRunOnItsThread(): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_refused', 'No.', 'refusal'), self::says('msg_2', 'Sunny.'));
        set_error_handler(static fn () => true, E_USER_WARNING);

        try {
            $this->compactedAfter($this->thread());
        } finally {
            restore_error_handler();
        }

        $this->assertSame([self::continues('msg_1'), [self::results('toolu_1')]], [$this->body(2)['thread'], $this->body(2)['messages']]);
    }

    #[Test]
    public function testACompactionThatAFallbackModelWroteLeavesTheRunOnAThread(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::json(200, ['usage' => self::usageOfAFallbackTo('claude-sonnet-4-6')] + self::message('msg_compacted', self::SUMMARY['content'], 'compaction')),
            self::says('msg_2', 'Sunny.'),
        );

        $this->compactedAfter($this->thread());

        $this->assertSame([self::CREATE, [self::SUMMARY]], [$this->body(2)['thread'], $this->body(2)['messages']]);
    }

    #[Test]
    public function testAThreadStopsThreadingWithTheCompactionOfARunnerOverIt(): void
    {
        $this->respond(
            self::says('msg_1', 'Sunny.'),
            self::error(400, ['error_code' => 'thread_unsupported_request', 'unsupported' => ['context_management']]),
            self::compacted(),
            self::says('msg_2', 'Rainy.'),
        );
        $thread = $this->newThread(messages: [self::ASK], betas: ['compact-2026-09-04'], unsupportedRequestBehavior: 'continue_unthreaded');

        $this->compactedAfter($thread)->send(self::MORE);

        $this->assertCount(4, $this->transporter->getRequests());
        $this->assertArrayNotHasKey('thread', $this->body(3));
        $this->assertSame(['compact-2026-09-04'], $this->betas(3));
        $this->assertSame([self::SUMMARY, self::MORE], $this->body(3)['messages']);
    }

    #[Test]
    public function testACompactionThatCannotUseAThreadIsRaisedOnAThreadThatRaisesSuchErrors(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1'),
            self::error(400, ['error_code' => 'thread_unsupported_request', 'unsupported' => ['context_management']]),
        );
        $thread = $this->thread();

        $this->assertThrows(BadRequestException::class, fn () => $this->compactedAfter($thread));

        $this->assertCount(2, $this->transporter->getRequests());
        $this->assertSame([self::ASK, self::toolUse('toolu_1'), self::results('toolu_1')], $this->wire($thread->messages()));
        $this->assertSame('msg_1', $thread->previousMessageId());
    }

    // -------------------------------------------------------------------------
    // Containers, betas and providers
    // -------------------------------------------------------------------------

    #[Test]
    public function testTheContainerOfAReplyAndTheCallersBetasAreSentOnLaterTurns(): void
    {
        $this->respond(
            self::calls('msg_1', 'toolu_1', container: ['id' => 'container_1', 'expires_at' => '2026-01-01T00:00:00Z']),
            self::says('msg_2', 'Sunny.'),
        );

        $thread = $this->newThread(
            messages: [self::ASK],
            container: ['skills' => []],
            tools: [$this->tool()],
            betas: ['files-api-2025-04-14'],
        );
        $thread->toolRunner()->runUntilDone();

        $this->assertEquals(['id' => 'container_1', 'skills' => []], $this->body(1)['container']);
        foreach ([0, 1] as $index) {
            $this->assertEqualsCanonicalizing(['files-api-2025-04-14', self::THREADS_BETA], $this->betas($index));
        }
    }

    /**
     * @param \Closure(MockClient): Client $factory
     */
    #[Test]
    #[DataProvider('platformClients')]
    public function testTheRunnerThreadsOnlyWhereThePlatformHasThreads(\Closure $factory, bool $threads): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));

        $final = $factory($this->transporter)->beta->messages->toolRunner(
            maxTokens: 64,
            messages: [self::ASK],
            model: 'claude-opus-4-6',
            tools: [$this->tool()],
        )->runUntilDone();

        $this->assertSame('msg_2', $final->id);
        $this->assertSame(['toolu_1'], $this->ran);
        foreach ([0, 1] as $index) {
            $body = $this->body($index);
            $this->assertSame($threads, array_key_exists('thread', $body));
            $this->assertSame($threads, str_contains($this->request($index)->getHeaderLine('anthropic-beta').json_encode($body), self::THREADS_BETA));
        }
        $this->assertCount($threads ? 1 : 3, (array) $this->body(1)['messages']);
    }

    /**
     * @param \Closure(MockClient): Client $factory
     */
    #[Test]
    #[DataProvider('platformClients')]
    public function testSystemAndToolsCanChangeDuringARunOnlyWhereThePlatformHasNoThreads(\Closure $factory, bool $threads): void
    {
        $this->respond(self::calls('msg_1', 'toolu_1'), self::says('msg_2', 'Sunny.'));
        $runner = $factory($this->transporter)->beta->messages->toolRunner(
            maxTokens: 64,
            messages: [self::ASK],
            model: 'claude-opus-4-6',
            tools: [$this->tool()],
        );
        if ($threads) {
            $this->expectException(\LogicException::class);
            $this->expectExceptionMessage('Cannot change `system` and `tools` on a thread:');
        }

        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->setMessagesParams(['system' => 'Be brief.', 'tools' => [$this->tool(), $this->tool('get_time')]]);
            }
        }

        $this->assertSame('msg_2', $message->id ?? null);
        $this->assertSame(['Be brief.', [self::TOOL, ['name' => 'get_time'] + self::TOOL]], [$this->body(1)['system'], $this->body(1)['tools']]);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @param array<string, mixed> $extraParams
     * @param array<string, mixed>|false|null $thread
     */
    private function runner(?int $maxIterations = null, array $extraParams = [], array|false|null $thread = null): BetaToolRunner
    {
        return $this->client->beta->messages->toolRunner(
            maxTokens: 64,
            messages: [self::ASK],
            model: 'claude-opus-4-6',
            tools: [$this->tool()],
            maxIterations: $maxIterations,
            extraParams: $extraParams,
            thread: $thread,
        );
    }

    private function thread(): BetaMessageThread
    {
        return $this->newThread(messages: [self::ASK], tools: [$this->tool()], betas: ['compact-2026-09-04']);
    }

    /**
     * Runs a runner over the thread that schedules a compaction while it handles the first reply.
     */
    private function compactedAfter(BetaMessageThread $thread): BetaMessageThread
    {
        $runner = $thread->toolRunner();
        foreach ($runner as $message) {
            if ('msg_1' === $message->id) {
                $runner->compactBeforeNextTurn();
            }
        }

        return $thread;
    }

    /**
     * @return list<ResponseInterface> a call of `get_weather`, one of `lookup`, one of `get_weather` again, and the final reply
     */
    private static function repliesThatCallChangedTools(): array
    {
        return [
            self::calls('msg_1', 'toolu_1'),
            self::calls('msg_2', 'toolu_2', name: 'lookup'),
            self::calls('msg_3', 'toolu_3'),
            self::says('msg_4', 'Done.'),
        ];
    }

    /**
     * Runs the runner, adding `lookup` while it handles the first reply and removing `get_weather` while it handles the second.
     *
     * @return string|null the id of the last reply
     */
    private function changeToolsDuring(BetaToolRunner $runner): ?string
    {
        $last = null;
        foreach ($runner as $message) {
            $last = $message->id;
            if ('msg_1' === $last) {
                $runner->addTools($this->tool('lookup'));
            } elseif ('msg_2' === $last) {
                $runner->removeTools('get_weather');
            }
        }

        return $last;
    }

    /**
     * @param int $first the index of the request that answers the first reply of repliesThatCallChangedTools()
     */
    private function assertToolChangesContinueTheThread(int $first): void
    {
        $notFound = ['type' => 'tool_result', 'tool_use_id' => 'toolu_3', 'content' => "Error: Tool 'get_weather' not found", 'is_error' => true];
        foreach ([
            ['msg_1', [self::results('toolu_1'), self::LOOKUP_ADDED]],
            ['msg_2', [self::results('toolu_2'), self::WEATHER_REMOVED]],
            ['msg_3', [['role' => 'user', 'content' => [$notFound]]]],
        ] as $offset => [$previous, $messages]) {
            $this->assertSame(
                ['max_tokens' => 64, 'messages' => $messages, 'model' => 'claude-opus-4-6', 'thread' => self::continues($previous)],
                $this->body($first + $offset),
            );
            $this->assertSame([self::TOOL_CHANGES_BETA, self::THREADS_BETA], $this->betas($first + $offset));
        }
    }

    private function tool(string $name = 'get_weather'): BetaRunnableTool
    {
        return new BetaRunnableTool(
            ['name' => $name] + self::TOOL,
            function (array $input): string {
                $this->ran[] = is_string($input['call'] ?? null) ? $input['call'] : '';

                return 'ran';
            },
        );
    }

    /**
     * @return array<string, mixed> the message in which the runner answers the calls
     */
    private static function results(string $id): array
    {
        return ['role' => 'user', 'content' => [['type' => 'tool_result', 'tool_use_id' => $id, 'content' => 'ran']]];
    }

    /**
     * @return array<string, mixed>
     */
    private static function toolUse(string $id): array
    {
        return ['role' => 'assistant', 'content' => [['type' => 'tool_use', 'id' => $id, 'input' => ['call' => $id], 'name' => 'get_weather']]];
    }

    /**
     * @return array<string, mixed>
     */
    private static function text(string $text): array
    {
        return ['role' => 'assistant', 'content' => [['type' => 'text', 'text' => $text]]];
    }

    private static function says(string $id, string $text, string $stopReason = 'end_turn'): ResponseInterface
    {
        return self::json(200, self::message($id, [['type' => 'text', 'text' => $text]], $stopReason));
    }

    private static function compacted(): ResponseInterface
    {
        return self::json(200, self::message('msg_compacted', self::SUMMARY['content'], 'compaction'));
    }

    /**
     * @param array<string, mixed>|null $container
     */
    private static function calls(string $id, string $call, ?array $container = null, string $name = 'get_weather'): ResponseInterface
    {
        $message = self::message($id, [['type' => 'tool_use', 'id' => $call, 'name' => $name, 'input' => ['call' => $call]]], 'tool_use');

        return self::json(200, null === $container ? $message : ['container' => $container] + $message);
    }

    /**
     * @param array<string, mixed> $details
     */
    private static function error(int $status, array $details = []): ResponseInterface
    {
        $error = ['type' => 'invalid_request_error', 'message' => 'The request was rejected.'];
        if ([] !== $details) {
            $error['details'] = $details;
        }

        return self::json($status, ['type' => 'error', 'error' => $error]);
    }
}
