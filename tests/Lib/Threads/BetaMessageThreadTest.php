<?php

declare(strict_types=1);

namespace Tests\Lib\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaAssistantMessageParam;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaSystemMessageParam;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaUserMessageParam;
use Anthropic\Client;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Lib\Threads\BetaMessageThread;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Anthropic\RequestOptions;
use Anthropic\Services\Beta\MessagesService;
use Http\Client\Exception\TransferException;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ThreadedCity implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public string $city;
}

/**
 * @internal
 *
 * @coversNothing
 */
final class BetaMessageThreadTest extends TestCase
{
    use MocksThreadRequests;

    private const THREADS_BETA = 'message-threads-2026-08-12';

    private const HI = ['role' => 'user', 'content' => 'Hi'];

    private const MORE = ['role' => 'user', 'content' => 'More'];

    private const LAST = ['role' => 'user', 'content' => 'Last'];

    private const TOOL = ['name' => 'get_weather', 'input_schema' => ['type' => 'object']];

    private const EPHEMERAL = ['type' => 'ephemeral'];

    private const FALLBACK_BETA = 'server-side-fallback-2026-07-01';

    private const FALLBACK_MODEL = 'claude-sonnet-4-6';

    private const FALLBACKS = [['model' => self::FALLBACK_MODEL]];

    private const FALLBACK_CONTENT = [
        ['type' => 'fallback', 'from' => ['model' => 'claude-opus-4-6'], 'to' => ['model' => self::FALLBACK_MODEL], 'trigger' => ['type' => 'refusal', 'category' => null]],
        ['type' => 'text', 'text' => 'One'],
    ];

    // -------------------------------------------------------------------------
    // State and one turn
    // -------------------------------------------------------------------------

    #[Test]
    public function testSeveralMessagesGoOutUnmergedInOneRequest(): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $thread = $this->newThread(messages: [self::HI]);
        $thread->append(self::MORE);

        $thread->send([['role' => 'user', 'content' => 'A'], ['role' => 'user', 'content' => 'B']]);

        $this->assertSame(
            [self::HI, self::MORE, ['role' => 'user', 'content' => 'A'], ['role' => 'user', 'content' => 'B']],
            $this->body(0)['messages'],
        );
    }

    #[Test]
    public function testAppendTakesMessagesAndListsOfMessages(): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $thread = $this->newThread();

        $thread->append();
        $thread->append(self::HI, [self::MORE, BetaMessageParam::with(content: 'Last', role: 'user')], []);
        $this->assertCount(3, $thread->messages());

        $thread->send();
        $this->assertEquals([self::HI, self::MORE, ['role' => 'user', 'content' => 'Last']], $this->body(0)['messages']);
    }

    #[Test]
    #[DataProvider('waysToSendATurn')]
    public function testATurnWithNothingStagedGoesOutForTheApiToAnswer(\Closure $turn): void
    {
        $rejected = self::error(400, 'invalid_request_error');
        $this->respond($rejected, $this->reply('msg_1', 'One'), $rejected, $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        foreach ([0, 2] as $index) {
            $this->assertThrows(BadRequestException::class, static fn () => $turn($thread));
            $this->assertCount($index + 1, $this->transporter->getRequests());
            $this->assertSame([], $this->body($index)['messages']);
            $thread->send(self::HI);
        }

        $this->assertSame(['type' => 'create'], $this->body(0)['thread'], 'With no reply to continue from, the turn starts a thread with the history');
        $this->assertSame(self::continues('msg_1'), $this->body(2)['thread']);
        $this->assertSame([self::continues('msg_1'), [self::HI]], [$this->body(3)['thread'], $this->body(3)['messages']]);
    }

    /**
     * @return iterable<string, array{\Closure(BetaMessageThread): mixed}>
     */
    public static function waysToSendATurn(): iterable
    {
        yield 'send()' => [static fn (BetaMessageThread $thread) => $thread->send()];

        yield 'stream()' => [static fn (BetaMessageThread $thread) => $thread->sendStream()];
    }

    #[Test]
    public function testStagingTheRecordedReplyIsANoOp(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();
        $reply = $thread->send(self::HI);

        $thread->append($reply);
        $thread->append(['role' => 'assistant', 'content' => $reply->content]);
        $thread->send(self::MORE);

        $this->assertSame([self::MORE], $this->body(1)['messages']);
        $this->assertCount(4, $thread->messages());
    }

    #[Test]
    public function testTheReplyAppendedAfterAnotherMessageIsStaged(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();
        $reply = $thread->send(self::HI);

        $thread->append(self::MORE, $reply, $reply, self::MORE);
        $thread->send();

        $this->assertSame([self::MORE, self::assistant('One'), self::assistant('One'), self::MORE], $this->body(1)['messages']);
    }

    #[Test]
    public function testAStagedAssistantMessageWithAnUnansweredToolCallIsSentAsGiven(): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $call = ['role' => 'assistant', 'content' => [['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => []]]];

        $this->newThread(messages: [self::HI, $call])->send(self::MORE);

        $this->assertEquals([self::HI, $call, self::MORE], $this->body(0)['messages']);
    }

    #[Test]
    public function testUnknownUnsupportedRequestBehaviorIsRejected(): void
    {
        $this->expectException(\ValueError::class);
        $this->newThread(unsupportedRequestBehavior: 'ignore');
    }

    #[Test]
    #[DataProvider('failures')]
    public function testACallThatFailsBeforeAReplyStartsTakesItsMessagesBack(\Closure $turn, \Exception|ResponseInterface $failure): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $thread = $this->newThread();
        $thread->send(self::HI);

        $this->respond($failure, $this->reply('msg_2', 'Two'));

        $this->assertThrows(APIException::class, static fn () => $turn($thread));

        $this->assertSame('msg_1', $thread->previousMessageId());
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));

        $thread->send(self::MORE);
        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(2)['thread'], $this->body(2)['messages']]);
        $this->assertSame($this->body(1)['messages'], $this->body(2)['messages']);
    }

    /**
     * @return iterable<string, array{\Closure(BetaMessageThread): mixed, ResponseInterface|\Exception}> a call that is given `MORE`, and what answers it
     */
    public static function failures(): iterable
    {
        $turns = [
            'send()' => static fn (BetaMessageThread $thread) => $thread->send(self::MORE),
            'stream()' => static fn (BetaMessageThread $thread) => $thread->sendStream(self::MORE),
        ];
        foreach ($turns as $way => $turn) {
            yield "{$way}, a 400" => [$turn, self::error(400, 'invalid_request_error')];

            yield "{$way}, a 500" => [$turn, self::error(500, 'api_error')];

            yield "{$way}, a 529" => [$turn, self::error(529, 'overloaded_error')];

            yield "{$way}, a transport error" => [$turn, new TransferException('connection reset')];

            if ('stream()' === $way) {
                yield "{$way}, an error event before message_start" => [$turn, self::sse(self::event('ping'), self::overloaded())];
            }
        }
    }

    #[Test]
    public function testTheCallAfterARejectedOneSendsOnlyItsOwnMessages(): void
    {
        $rejected = self::error(400, 'invalid_request_error');
        $this->respond($rejected, $this->reply('msg_1', 'One'), $rejected, $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        foreach ([0, 2] as $index) {
            $this->assertThrows(BadRequestException::class, static fn () => $thread->send(['role' => 'user', 'content' => '']));
            $thread->send(self::HI);
            $this->assertSame([self::HI], $this->body($index + 1)['messages']);
        }

        $this->assertSame([['type' => 'create'], self::continues('msg_1')], [$this->body(1)['thread'], $this->body(3)['thread']]);
        $this->assertSame([self::HI, self::assistant('One'), self::HI, self::assistant('Two')], $this->wire($thread->messages()));
    }

    #[Test]
    public function testAppendedMessagesStayStagedWhenACallFails(): void
    {
        $failure = self::error(500, 'api_error');
        $this->respond($this->reply('msg_1', 'One'), $failure, $failure, $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();
        $thread->send(self::HI);
        $thread->append(self::MORE);

        $this->assertThrows(APIException::class, static fn () => $thread->send([self::HI, self::HI]));
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->wire($thread->messages()));
        $this->assertThrows(APIException::class, static fn () => $thread->send());
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->wire($thread->messages()));
        $thread->send();

        $this->assertSame(
            [[self::MORE, self::HI, self::HI], [self::MORE], [self::MORE]],
            array_map(fn (int $index) => $this->body($index)['messages'], [1, 2, 3]),
        );
    }

    #[Test]
    public function testAFailedReplayTakesTheMessagesBackAndTheNextTurnStillStartsANewThread(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']),
            self::error(500, 'api_error'),
            $this->reply('msg_2', 'Two'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);

        $this->assertThrows(APIException::class, static fn () => $thread->send(self::MORE));
        $this->assertNull($thread->previousMessageId());
        $thread->send(self::MORE);

        $this->assertSame([['type' => 'create'], [self::HI, self::assistant('One'), self::MORE]], [$this->body(3)['thread'], $this->body(3)['messages']]);
    }

    #[Test]
    #[DataProvider('replayCodes')]
    public function testARejectedContinueIsSentAgainAsACreate(int $status, string $code): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::error($status, 'invalid_request_error', ['error_code' => $code]),
            $this->reply('msg_2', 'Two'),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread(system: 'Be brief.', tools: [self::TOOL]);
        $thread->send(self::HI);

        $reply = $thread->send(self::MORE);

        $this->assertSame('msg_2', $reply->id);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertSame(['type' => 'create'], $this->body(2)['thread']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->body(2)['messages']);
        $this->assertSame('Be brief.', $this->body(2)['system']);
        $this->assertSame([self::TOOL], $this->body(2)['tools']);
        $this->assertSame([self::THREADS_BETA], $this->betas(2));

        $thread->send(['role' => 'user', 'content' => 'Last']);
        $this->assertSame(self::continues('msg_2'), $this->body(3)['thread']);
    }

    /**
     * @return iterable<string, array{int, string}>
     */
    public static function replayCodes(): iterable
    {
        yield 'thread_not_found' => [404, 'thread_not_found'];

        yield 'thread_already_continued' => [409, 'thread_already_continued'];

        yield 'thread_continue_in_flight' => [409, 'thread_continue_in_flight'];
    }

    #[Test]
    public function testAReplayCodeOnACreateIsRaisedAfterOneRequest(): void
    {
        $this->respond(self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']));
        $thread = $this->newThread();

        $this->assertThrows(NotFoundException::class, static fn () => $thread->send(self::HI));

        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame([], $thread->messages());
    }

    /**
     * @param \Closure(BetaMessageThread): mixed $turn
     */
    #[Test]
    #[DataProvider('turnsOnAThreadThatIsNotFoundAgain')]
    public function testAThreadThatIsNotFoundRightAfterItReplacedOneThatWasNotFoundGoesOnWithoutAThread(\Closure $turn, ResponseInterface $reply): void
    {
        $this->respond($this->reply('msg_1', 'One'), self::notFound(), $this->reply('msg_2', 'Two'), self::notFound(), $reply, $this->reply('msg_4', 'Four'));
        $thread = $this->newThread(system: 'Be brief.', unsupportedRequestBehavior: 'continue_unthreaded');
        $thread->send(self::HI);
        $thread->send(self::MORE);

        $turn($thread);
        $thread->send(self::HI);

        $history = [self::HI, self::assistant('One'), self::MORE, self::assistant('Two'), self::LAST];
        $this->assertSame([['type' => 'create'], self::continues('msg_1'), ['type' => 'create'], self::continues('msg_2'), null, null], $this->threads());
        $this->assertSame([$history, 'Be brief.', []], [$this->body(4)['messages'], $this->body(4)['system'], $this->betas(4)]);
        $this->assertSame([[...$history, self::assistant('Three'), self::HI], 'Be brief.', []], [$this->body(5)['messages'], $this->body(5)['system'], $this->betas(5)]);
    }

    /**
     * @return iterable<string, array{\Closure(BetaMessageThread): mixed, ResponseInterface}> a call that is given `LAST`, and its reply
     */
    public static function turnsOnAThreadThatIsNotFoundAgain(): iterable
    {
        yield 'send()' => [
            static fn (BetaMessageThread $thread) => $thread->send(self::LAST),
            self::json(200, self::message('msg_3', self::assistant('Three')['content'], 'end_turn')),
        ];

        yield 'stream()' => [
            static fn (BetaMessageThread $thread) => iterator_to_array($thread->sendStream(self::LAST), false),
            self::sse(self::start('msg_3'), ...self::text(0, 'Three'), ...self::stop()),
        ];
    }

    /**
     * @param list<ResponseInterface> $responses
     * @param list<array<string, string>|null> $threads the `thread` of each request
     */
    #[Test]
    #[DataProvider('threadsThatAreNotFound')]
    public function testAThreadStopsThreadingOnlyWhenTheFirstContinueAfterAReplayIsNotFoundToo(string $behavior, array $responses, int $turns, array $threads): void
    {
        $this->respond(...$responses);
        $thread = $this->newThread(unsupportedRequestBehavior: $behavior);

        for ($turn = 0; $turn < $turns; ++$turn) {
            try {
                $thread->send(self::HI);
            } catch (APIStatusException $e) {
                $this->assertSame(500, $e->status);
            }
        }

        $this->assertSame($threads, $this->threads());
    }

    /**
     * @return iterable<string, array{string, list<ResponseInterface>, int, list<array<string, string>|null>}>
     */
    public static function threadsThatAreNotFound(): iterable
    {
        $create = ['type' => 'create'];
        $says = static fn (int $id, string $stopReason = 'end_turn') => self::json(200, self::message("msg_{$id}", [['type' => 'text', 'text' => 'Yes']], $stopReason));
        $continued = static fn () => self::error(409, 'invalid_request_error', ['error_code' => 'thread_already_continued']);

        yield 'on a thread that raises what it cannot thread' => [
            'error',
            [$says(1), self::notFound(), $says(2), self::notFound(), $says(3), $says(4)],
            4,
            [$create, self::continues('msg_1'), $create, self::continues('msg_2'), $create, self::continues('msg_3')],
        ];

        yield 'after a continue that was answered' => [
            'continue_unthreaded',
            [$says(1), self::notFound(), $says(2), $says(3), self::notFound(), $says(4), $says(5)],
            5,
            [$create, self::continues('msg_1'), $create, self::continues('msg_2'), self::continues('msg_3'), $create, self::continues('msg_4')],
        ];

        yield 'after a replay for another reason' => [
            'continue_unthreaded',
            [$says(1), $continued(), $says(2), self::notFound(), $says(3), $says(4)],
            4,
            [$create, self::continues('msg_1'), $create, self::continues('msg_2'), $create, self::continues('msg_3')],
        ];

        yield 'rejected for another reason' => [
            'continue_unthreaded',
            [$says(1), self::notFound(), $says(2), $continued(), $says(3), $says(4)],
            4,
            [$create, self::continues('msg_1'), $create, self::continues('msg_2'), $create, self::continues('msg_3')],
        ];

        yield 'after a replay that was refused' => [
            'continue_unthreaded',
            [$says(1), self::notFound(), $says(2, 'refusal'), $says(3), self::notFound(), $says(4), $says(5)],
            5,
            [$create, self::continues('msg_1'), $create, $create, self::continues('msg_3'), $create, self::continues('msg_4')],
        ];

        yield 'after a replay that failed and was made again' => [
            'continue_unthreaded',
            [$says(1), self::notFound(), self::error(500, 'api_error'), $says(2), self::notFound(), $says(3)],
            4,
            [$create, self::continues('msg_1'), $create, $create, self::continues('msg_2'), null],
        ];
    }

    #[Test]
    #[DataProvider('errorsThatAreNotRecovered')]
    public function testOtherErrorsReachTheCaller(ResponseInterface $error): void
    {
        $this->respond($this->reply('msg_1', 'One'), $error, $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(unsupportedRequestBehavior: 'continue_unthreaded');
        $thread->send(self::HI);

        $e = $this->assertThrows(APIStatusException::class, static fn () => $thread->send(self::MORE));
        $this->assertSame($error->getStatusCode(), $e->status);

        $this->assertCount(2, $this->transporter->getRequests());
        $this->assertSame('msg_1', $thread->previousMessageId());
        $thread->send(self::MORE);
        $this->assertSame(self::continues('msg_1'), $this->body(2)['thread']);
        $this->assertSame([self::MORE], $this->body(2)['messages']);
    }

    /**
     * @return iterable<string, array{ResponseInterface}>
     */
    public static function errorsThatAreNotRecovered(): iterable
    {
        yield '404 without a thread code' => [self::error(404, 'not_found_error')];

        yield 'thread_fingerprint_mismatch' => [self::error(400, 'invalid_request_error', ['error_code' => 'thread_fingerprint_mismatch'])];

        yield 'a body that is not JSON' => [self::raw(404, 'thread_not_found')];

        yield 'a replay code in the message only' => [self::error(404, 'not_found_error', message: 'thread_not_found')];
    }

    #[Test]
    public function testAnUnsupportedRequestIsRaisedByDefault(): void
    {
        $this->respond(self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request', 'unsupported' => ['fallbacks']]));
        $thread = $this->newThread();

        $this->assertThrows(BadRequestException::class, static fn () => $thread->send(self::HI));

        $this->assertCount(1, $this->transporter->getRequests());
    }

    #[Test]
    public function testContinueUnthreadedSendsTheRequestAgainWithoutAThread(): void
    {
        $this->respond(
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request', 'unsupported' => ['fallbacks']]),
            $this->reply('msg_1', 'One'),
            $this->reply('msg_2', 'Two'),
        );
        $thread = $this->newThread(system: 'Be brief.', betas: ['files-api-2025-04-14'], unsupportedRequestBehavior: 'continue_unthreaded');

        $reply = $thread->send(self::HI);
        $thread->send(self::MORE);

        $this->assertSame('msg_1', $reply->id);
        $this->assertArrayNotHasKey('thread', $this->body(1));
        $this->assertSame([self::HI], $this->body(1)['messages']);
        $this->assertSame(['files-api-2025-04-14'], $this->betas(1));
        $this->assertArrayNotHasKey('thread', $this->body(2));
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->body(2)['messages']);
        $this->assertSame('Be brief.', $this->body(2)['system']);
        $this->assertSame(['files-api-2025-04-14'], $this->betas(2));
        $this->assertNull($thread->previousMessageId());
    }

    #[Test]
    public function testAPausedTurnResumesWithNoMessages(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One', 'pause_turn'),
            $this->reply('msg_2', 'Two', 'pause_turn'),
            $this->reply('msg_3', 'Three'),
            $this->reply('msg_4', 'Four'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);

        $thread->send();
        $thread->send();
        $thread->send(self::MORE);

        $this->assertSame([], $this->body(1)['messages']);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertSame([], $this->body(2)['messages']);
        $this->assertSame(self::continues('msg_2'), $this->body(2)['thread']);
        $this->assertSame([self::MORE], $this->body(3)['messages']);
        $this->assertSame(self::continues('msg_3'), $this->body(3)['thread']);
    }

    // -------------------------------------------------------------------------
    // Refusals
    // -------------------------------------------------------------------------

    /**
     * @param \Closure(BetaMessageThread): ?string $turn
     */
    #[Test]
    #[DataProvider('refusedTurns')]
    public function testARefusedTurnIsNotRecordedAndTheNextTurnStartsANewThread(\Closure $turn, ResponseInterface $refusal): void
    {
        $this->respond($this->reply('msg_1', 'One'), $refusal, $this->reply('msg_3', 'Three'), $this->reply('msg_4', 'Four'));
        $thread = $this->newThread(system: 'Be brief.', tools: [self::TOOL]);
        $thread->send(self::HI);

        $this->assertSame('refusal', $turn($thread));

        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));
        $this->assertSame('msg_1', $thread->lastMessage()?->id);
        $this->assertNull($thread->previousMessageId());

        $thread->send(self::LAST);
        $thread->send(self::MORE);

        $this->assertCount(4, $this->transporter->getRequests());
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::HI, self::assistant('One'), self::LAST],
                'model' => 'claude-opus-4-6',
                'system' => 'Be brief.',
                'thread' => ['type' => 'create'],
                'tools' => [self::TOOL],
            ],
            $this->body(2),
        );
        $this->assertSame(self::continues('msg_3'), $this->body(3)['thread']);
    }

    /**
     * @return iterable<string, array{\Closure(BetaMessageThread): ?string, ResponseInterface}> a call that is given `MORE` and returns the stop reason that the caller sees, and the refusal that answers it
     */
    public static function refusedTurns(): iterable
    {
        yield 'send()' => [
            static fn (BetaMessageThread $thread) => $thread->send(self::MORE)->stopReason,
            self::json(200, self::message('msg_2', [['type' => 'text', 'text' => 'No.']], 'refusal')),
        ];

        yield 'stream()' => [
            static function (BetaMessageThread $thread) {
                $stopReason = null;
                foreach ($thread->sendStream(self::MORE) as $event) {
                    $stopReason = $event instanceof BetaRawMessageDeltaEvent ? $event->delta->stopReason : $stopReason;
                }

                return $stopReason;
            },
            self::sse(self::start('msg_2'), ...self::text(0, 'No.'), ...self::stop('refusal')),
        ];
    }

    /**
     * @param list<array<string, mixed>> $left what the turn leaves in the history
     */
    #[Test]
    #[DataProvider('stopReasonsSeenBeforeAStreamIsLeft')]
    public function testAStreamLeftAfterItsStopReasonArrivedIsRecordedUnlessItIsARefusal(string $stopReason, array $left, string $lastMessage): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop($stopReason)),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread(system: 'Be brief.');
        $thread->send(self::HI);
        $thread->append(self::MORE);

        foreach ($thread->sendStream(self::HI) as $event) {
            if ('message_delta' === $event->type) {
                break;
            }
        }

        $this->assertSame([self::continues('msg_1'), [self::MORE, self::HI]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertSame([self::HI, self::assistant('One'), ...$left], $this->wire($thread->messages()));
        $this->assertSame($lastMessage, $thread->lastMessage()?->id);
        $this->assertNull($thread->previousMessageId());

        $thread->send(self::LAST);

        $this->assertSame(
            [['type' => 'create'], [self::HI, self::assistant('One'), ...$left, self::LAST], 'Be brief.'],
            [$this->body(2)['thread'], $this->body(2)['messages'], $this->body(2)['system']],
        );
    }

    /**
     * @return iterable<string, array{string, list<array<string, mixed>>, string}> the stop reason, what a turn that is given `HI` after `MORE` was appended leaves in the history, and the id of the last message
     */
    public static function stopReasonsSeenBeforeAStreamIsLeft(): iterable
    {
        yield 'refusal' => ['refusal', [self::MORE], 'msg_1'];

        yield 'end_turn' => ['end_turn', [self::MORE, self::HI, self::assistant('Two')], 'msg_2'];
    }

    #[Test]
    public function testARefusedFirstTurnLeavesTheSeedAndNoSystemOrToolsOfItsOwn(): void
    {
        $this->respond($this->reply('msg_1', 'No.', 'refusal'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(messages: [self::HI, self::assistant('One')]);

        $thread->send(self::MORE, ['system' => 'Be brief.', 'tools' => [self::TOOL]]);
        $this->assertNull($thread->lastMessage());
        $thread->send(self::LAST);

        $this->assertSame(['Be brief.', [self::TOOL]], [$this->body(0)['system'], $this->body(0)['tools']]);
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::HI, self::assistant('One'), self::LAST], 'model' => 'claude-opus-4-6', 'thread' => ['type' => 'create']],
            $this->body(1),
        );
    }

    #[Test]
    public function testAppendedMessagesStayStagedWhenATurnIsRefused(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'No.', 'refusal'), $this->reply('msg_3', 'Three'));
        $thread = $this->newThread();
        $thread->send(self::HI);
        $thread->append(self::MORE);

        $thread->send(self::HI);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->wire($thread->messages()));
        $thread->send(self::LAST);

        $this->assertSame([self::MORE, self::HI], $this->body(1)['messages']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::LAST], $this->body(2)['messages']);
    }

    #[Test]
    public function testARefusedTurnIsNotRecordedWithoutAThreadEither(): void
    {
        $this->respond(
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']),
            $this->reply('msg_1', 'One'),
            $this->reply('msg_2', 'No.', 'refusal'),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread(unsupportedRequestBehavior: 'continue_unthreaded');
        $thread->send(self::HI);

        $thread->send(self::MORE);
        $thread->send(self::LAST);

        $this->assertArrayNotHasKey('thread', $this->body(3));
        $this->assertSame([self::HI, self::assistant('One'), self::LAST], $this->body(3)['messages']);
    }

    // -------------------------------------------------------------------------
    // Fallback models
    // -------------------------------------------------------------------------

    /**
     * @param \Closure(BetaMessageThread): mixed $turn
     */
    #[Test]
    #[DataProvider('turnsThatAFallbackModelAnswers')]
    public function testAReplyOfAFallbackModelOnlyStartsANewThread(\Closure $turn, ResponseInterface $reply): void
    {
        $this->respond(
            $reply,
            self::json(200, ['usage' => self::usageOfAFallbackTo(self::FALLBACK_MODEL)] + self::message('msg_2', self::FALLBACK_CONTENT, 'end_turn')),
            $this->reply('msg_3', 'Three'),
            $this->reply('msg_4', 'Four'),
        );
        $thread = $this->newThread(system: 'Be brief.', tools: [self::TOOL], fallbacks: self::FALLBACKS, betas: [self::FALLBACK_BETA]);
        $given = $thread->params();

        $turn($thread);

        $this->assertSame('msg_1', $thread->lastMessage()?->id);
        $this->assertNull($thread->previousMessageId());
        $this->assertSame(['messages' => $thread->messages()] + $given, ['messages' => $thread->messages()] + $thread->params());

        $thread->send(self::MORE);
        $thread->send(self::LAST);
        $thread->send(self::HI);

        $answer = ['role' => 'assistant', 'content' => self::FALLBACK_CONTENT];
        $request = static fn (array $messages, array $thread) => [
            'max_tokens' => 64,
            'messages' => $messages,
            'model' => 'claude-opus-4-6',
            'fallbacks' => self::FALLBACKS,
            ...$thread,
        ];
        $create = ['system' => 'Be brief.', 'thread' => ['type' => 'create'], 'tools' => [self::TOOL]];
        $this->assertSame($request([self::HI], $create), array_diff_key($this->body(0), ['stream' => true]));
        $this->assertSame($request([self::HI, $answer, self::MORE], $create), $this->body(1));
        $this->assertSame($request([self::HI, $answer, self::MORE, $answer, self::LAST], $create), $this->body(2));
        $this->assertSame($request([self::HI], ['thread' => self::continues('msg_3')]), $this->body(3));
        foreach ([0, 1, 2, 3] as $index) {
            $this->assertSame([self::FALLBACK_BETA, self::THREADS_BETA], $this->betas($index));
        }
    }

    /**
     * @return iterable<string, array{\Closure(BetaMessageThread): mixed, ResponseInterface}> a call that is given `HI`, and the reply of the fallback model
     */
    public static function turnsThatAFallbackModelAnswers(): iterable
    {
        $usage = self::usageOfAFallbackTo(self::FALLBACK_MODEL);

        yield 'send()' => [
            static fn (BetaMessageThread $thread) => $thread->send(self::HI),
            self::json(200, ['usage' => $usage] + self::message('msg_1', self::FALLBACK_CONTENT, 'end_turn')),
        ];

        yield 'stream()' => [
            static fn (BetaMessageThread $thread) => iterator_to_array($thread->sendStream(self::HI), false),
            self::sse(
                self::start('msg_1'),
                self::event('content_block_start', ['index' => 0, 'content_block' => self::FALLBACK_CONTENT[0]]),
                self::blockStop(0),
                ...self::text(1, 'One'),
                ...[self::event('message_delta', ['delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null], 'usage' => $usage]), self::event('message_stop')],
            ),
        ];
    }

    #[Test]
    public function testARefusalOfAFallbackModelIsNotRecorded(): void
    {
        $this->respond(
            self::json(200, ['usage' => self::usageOfAFallbackTo(self::FALLBACK_MODEL)] + self::message('msg_1', self::FALLBACK_CONTENT, 'refusal')),
            $this->reply('msg_2', 'Two'),
        );
        $thread = $this->newThread(fallbacks: self::FALLBACKS);

        $thread->send(self::HI);
        $thread->send(self::MORE);

        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::MORE], 'model' => 'claude-opus-4-6', 'fallbacks' => self::FALLBACKS, 'thread' => ['type' => 'create']],
            $this->body(1),
        );
    }

    #[Test]
    public function testAReplyOfTheRequestedModelLeavesTheThreadAsItIs(): void
    {
        $usage = self::usageOfAFallbackTo(self::FALLBACK_MODEL);
        $this->assertIsArray($usage['iterations']);
        unset($usage['iterations'][1]);
        $usage['iterations'] = array_values($usage['iterations']);
        $this->respond(self::json(200, ['usage' => $usage] + self::message('msg_1', self::assistant('One')['content'], 'end_turn')), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(fallbacks: self::FALLBACKS);

        $thread->send(self::HI);
        $thread->send(self::MORE);

        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::MORE], 'model' => 'claude-opus-4-6', 'fallbacks' => self::FALLBACKS, 'thread' => self::continues('msg_1')],
            $this->body(1),
        );
    }

    #[Test]
    public function testAReplyOfAFallbackModelChangesNothingWithoutAThread(): void
    {
        $this->respond(
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request', 'unsupported' => ['fallbacks']]),
            self::json(200, ['usage' => self::usageOfAFallbackTo(self::FALLBACK_MODEL)] + self::message('msg_1', self::FALLBACK_CONTENT, 'end_turn')),
            $this->reply('msg_2', 'Two'),
        );
        $thread = $this->newThread(fallbacks: self::FALLBACKS, unsupportedRequestBehavior: 'continue_unthreaded');

        $thread->send(self::HI);
        $thread->send(self::MORE);

        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::HI, ['role' => 'assistant', 'content' => self::FALLBACK_CONTENT], self::MORE],
                'model' => 'claude-opus-4-6',
                'fallbacks' => self::FALLBACKS,
            ],
            $this->body(2),
        );
    }

    // -------------------------------------------------------------------------
    // Cache breakpoints
    // -------------------------------------------------------------------------

    #[Test]
    public function testAHistoryThatIsSentAgainCarriesOnlyTheCacheBreakpointsOfTheNewMessages(): void
    {
        $turns = [
            self::marked('1'),
            ['role' => 'user', 'content' => [['type' => 'text', 'text' => '2', 'cacheControl' => self::EPHEMERAL]]],
            BetaMessageParam::with(content: [BetaTextBlockParam::with(text: '3', cacheControl: self::EPHEMERAL)], role: 'user'),
            ['role' => 'user', 'content' => [BetaTextBlockParam::with(text: '4', cacheControl: self::EPHEMERAL)]],
            self::marked('5'),
        ];
        $given = $this->wire($turns);
        $thread = $this->newThread();
        foreach ($turns as $index => $turn) {
            $this->respond($this->reply("msg_{$index}", 'Yes'));
            $thread->send($turn);
            $this->assertSame([self::marked((string) ($index + 1))], $this->body($index)['messages']);
        }
        $this->respond(self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']), $this->reply('msg_6', 'Yes'));

        $thread->send(self::marked('6'));

        $this->assertSame([self::continues('msg_4'), [self::marked('6')]], [$this->body(5)['thread'], $this->body(5)['messages']]);
        $this->assertSame(['type' => 'create'], $this->body(6)['thread']);
        $this->assertSame(
            [...array_merge(...array_map(static fn (int $turn) => [self::unmarked((string) $turn), self::assistant('Yes')], range(1, 5))), self::marked('6')],
            $this->body(6)['messages'],
        );
        $this->assertSame(1, substr_count((string) $this->request(6)->getBody(), 'cache_control'));

        $this->assertSame($given, $this->wire($turns));
        $this->assertSame([...$turns, self::marked('6')], array_values(array_filter($thread->messages(), static fn ($message) => 'user' === $message['role'])));
    }

    #[Test]
    public function testTheFirstRequestOfAThreadIsSentAsGiven(): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $seed = [self::marked('1'), self::assistant('One'), self::marked('2')];
        $thread = $this->newThread(messages: $seed);
        $thread->append(self::marked('3'));

        $thread->send(self::marked('4'));

        $this->assertSame([...$seed, self::marked('3'), self::marked('4')], $this->body(0)['messages']);
    }

    /**
     * @param list<ResponseInterface> $responses
     * @param \Closure(BetaMessageThread): mixed $turn
     */
    #[Test]
    #[DataProvider('turnsThatSendTheHistoryAgain')]
    public function testEveryRequestThatSendsTheHistoryAgainLeavesItsCacheBreakpointsOut(array $responses, \Closure $turn): void
    {
        $this->respond($this->reply('msg_1', 'One'), ...$responses);
        $thread = $this->newThread(unsupportedRequestBehavior: 'continue_unthreaded');
        $thread->send(self::marked('1'));
        $thread->append(self::marked('2'));

        $turn($thread);

        $this->assertSame(
            [self::unmarked('1'), self::assistant('One'), self::marked('2'), self::marked('3')],
            $this->body(count($this->transporter->getRequests()) - 1)['messages'],
        );
    }

    /**
     * @return iterable<string, array{list<ResponseInterface>, \Closure(BetaMessageThread): mixed}> the responses to a call, and the call, whose last request is given the marked message 3
     */
    public static function turnsThatSendTheHistoryAgain(): iterable
    {
        $reply = static fn () => self::json(200, self::message('msg_3', [['type' => 'text', 'text' => 'Three']], 'end_turn'));
        $send = static fn (BetaMessageThread $thread) => $thread->send(self::marked('3'));

        yield 'the first turn of a fork' => [[$reply()], static fn (BetaMessageThread $thread) => $send($thread->fork())];

        yield 'a turn without a thread' => [[self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']), $reply()], $send];

        yield 'the turn after a refusal' => [
            [self::json(200, self::message('msg_2', [], 'refusal')), $reply()],
            static fn (BetaMessageThread $thread) => [$thread->send(self::HI), $send($thread)],
        ];
    }

    /**
     * @param list<array<string, mixed>> $given the messages given to the call after the stream
     */
    #[Test]
    #[DataProvider('callsAfterAStreamThatEndedBeforeAnyContent')]
    public function testMessagesThatWereNeverAnsweredKeepTheirCacheBreakpoints(array $given): void
    {
        $unanswered = ['role' => 'user', 'content' => [...self::marked('2')['content'], ...self::marked('3')['content']]];
        $this->respond($this->reply('msg_1', 'One'), self::sse(self::start('msg_2')), $this->reply('msg_3', 'Three'));
        $thread = $this->newThread();
        $thread->send(self::marked('1'));
        iterator_to_array($thread->sendStream($unanswered), false);

        $thread->send($given);

        $this->assertSame(['type' => 'create'], $this->body(2)['thread']);
        $this->assertSame([self::unmarked('1'), self::assistant('One'), $unanswered, ...$given], $this->body(2)['messages']);
    }

    /**
     * @return iterable<string, array{list<array<string, mixed>>}>
     */
    public static function callsAfterAStreamThatEndedBeforeAnyContent(): iterable
    {
        yield 'with no message, which sends the turn again' => [[]];

        yield 'with a new message' => [[self::marked('4')]];
    }

    #[Test]
    #[DataProvider('waysToGiveAMessage')]
    public function testCacheBreakpointsInsideABlockAreLeftOutAndFreeFormJsonIsKept(bool $asModels): void
    {
        $kept = ['cache_control' => self::EPHEMERAL];
        $text = ['type' => 'text', 'text' => 'Sunny'];
        $addition = static fn (array $mark) => ['type' => 'tool_addition', 'tool' => ['type' => 'tool_definition', 'definition' => [
            'name' => 'lookup',
            'input_schema' => ['type' => 'object', 'properties' => ['cache_control' => ['type' => 'string']]],
            'input_examples' => [['cache_control' => 'no-store']],
        ] + $mark]] + $mark;
        $blocks = static fn (array $mark) => [
            ['role' => 'assistant', 'content' => [
                ['type' => 'compaction', 'content' => 'Summary', 'tool_changes' => [$addition($kept)]] + $mark,
                ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => ['cache_control' => 'of the tool']] + $mark,
            ]],
            ['role' => 'user', 'content' => [
                ['type' => 'tool_result', 'tool_use_id' => 'toolu_1', 'content' => [$text + $mark]] + $mark,
                ['type' => 'document', 'source' => ['type' => 'content', 'content' => [$text + $mark]]],
                ['type' => 'search_result', 'source' => 'https://example.com', 'title' => 'Weather', 'content' => [$text + $mark]],
                ['type' => 'tool_search_tool_result', 'tool_use_id' => 'srvtoolu_1', 'content' => [
                    'type' => 'tool_search_tool_search_result',
                    'tool_references' => [['type' => 'tool_reference', 'tool_name' => 'lookup'] + $mark],
                ]],
            ]],
            ['role' => 'system', 'content' => [$addition($mark)]],
        ];
        $given = array_map(
            static fn (array $message) => match (true) {
                !$asModels => $message,
                'user' === $message['role'] => BetaUserMessageParam::fromArray($message),
                'assistant' === $message['role'] => BetaAssistantMessageParam::fromArray($message),
                default => BetaSystemMessageParam::fromArray($message),
            },
            $blocks($kept),
        );
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();
        $thread->send([self::HI, ...$given]);

        $thread->fork()->send(self::MORE);

        $this->assertEquals([self::HI, ...$blocks($kept)], $this->body(0)['messages']);
        $this->assertEquals([self::HI, ...$blocks([]), self::assistant('One'), self::MORE], $this->body(1)['messages']);
        $this->assertEquals($blocks($kept), $this->wire($given));
    }

    /**
     * @return iterable<string, array{bool}>
     */
    public static function waysToGiveAMessage(): iterable
    {
        yield 'as arrays' => [false];

        yield 'as models' => [true];
    }

    #[Test]
    public function testTheCacheBreakpointsOutsideTheMessagesAreSentAgain(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(
            cacheControl: self::EPHEMERAL,
            system: [['type' => 'text', 'text' => 'Be brief.', 'cache_control' => self::EPHEMERAL]],
            tools: [self::TOOL + ['cache_control' => self::EPHEMERAL]],
        );
        $thread->send(self::HI);

        $thread->fork()->send(self::MORE);

        foreach (['cache_control', 'system', 'tools'] as $field) {
            $this->assertStringContainsString('ephemeral', json_encode($this->body(1)[$field], JSON_THROW_ON_ERROR));
            $this->assertSame($this->body(0)[$field], $this->body(1)[$field]);
        }
    }

    // -------------------------------------------------------------------------
    // Fields, headers and betas
    // -------------------------------------------------------------------------

    #[Test]
    public function testFieldsOfATurnApplyToOneRequestAndUpdateToLaterOnes(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'), $this->reply('msg_3', 'Three'), $this->reply('msg_4', 'Four'));
        $thread = $this->newThread(stopSequences: ['A'], serviceTier: 'auto');

        $thread->send(self::HI, ['stopSequences' => ['B'], 'serviceTier' => null]);
        $thread->send(self::HI);
        $thread->update(['stopSequences' => ['C'], 'serviceTier' => null, 'maxTokens' => 128]);
        $this->assertCount(2, $this->transporter->getRequests());
        $thread->send(self::HI);
        $thread->send(self::HI, ['stopSequences' => ['D']]);

        $this->assertSame([['B'], ['A'], ['C'], ['D']], array_map(fn (int $i) => $this->body($i)['stop_sequences'], [0, 1, 2, 3]));
        $this->assertSame([null, 'auto', null, null], array_map(fn (int $i) => $this->body($i)['service_tier'] ?? null, [0, 1, 2, 3]));
        $this->assertSame([64, 64, 128, 128], array_map(fn (int $i) => $this->body($i)['max_tokens'], [0, 1, 2, 3]));
        $this->assertSame(self::continues('msg_3'), $this->body(3)['thread']);
    }

    #[Test]
    public function testARequestOptionGivenLaterReplacesTheThreadsAsAWhole(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
            $this->reply('msg_3', 'Three'),
            $this->reply('msg_4', 'Four'),
            $this->reply('msg_5', 'Five'),
        );
        $both = ['one' => 'creation', 'two' => 'creation'];
        $thread = $this->newThread(requestOptions: ['extraHeaders' => $both, 'extraQueryParams' => $both, 'extraBodyParams' => $both]);

        $turn = ['two' => 'turn'];
        $thread->send(self::HI, requestOptions: ['extraHeaders' => $turn, 'extraQueryParams' => $turn, 'extraBodyParams' => $turn]);
        iterator_to_array($thread->sendStream(self::MORE, requestOptions: RequestOptions::with(extraHeaders: $turn)), false);
        $thread->send(self::MORE, requestOptions: ['timeout' => 5.0]);
        $thread->update([], ['extraHeaders' => ['three' => 'update']]);
        $thread->send(self::MORE);
        $thread->send(self::MORE, requestOptions: ['extraHeaders' => []]);

        $sent = [];
        foreach (array_keys($this->transporter->getRequests()) as $index) {
            parse_str($this->request($index)->getUri()->getQuery(), $query);
            $sent[] = [
                array_map(fn (string $name) => $this->request($index)->getHeaderLine($name), ['one', 'two', 'three']),
                [$query['one'] ?? null, $query['two'] ?? null],
                [$this->body($index)['one'] ?? null, $this->body($index)['two'] ?? null],
            ];
            $this->assertSame([self::THREADS_BETA], $this->betas($index));
        }
        $kept = ['creation', 'creation'];
        $this->assertSame(
            [
                [['', 'turn', ''], [null, 'turn'], [null, 'turn']],
                [['', 'turn', ''], $kept, $kept],
                [['creation', 'creation', ''], $kept, $kept],
                [['', '', 'update'], $kept, $kept],
                [['', '', ''], $kept, $kept],
            ],
            $sent,
        );
        $this->assertSame(array_fill(0, 5, 'message-thread'), $this->helperHeaders());
    }

    /**
     * @param array<string, mixed> $value
     */
    #[Test]
    #[DataProvider('threadValues')]
    public function testAThreadValueOfTheCallerIsRefused(array $value): void
    {
        $thread = $this->newThread();

        foreach ([
            fn () => new BetaMessageThread($this->client, ['maxTokens' => 64, 'model' => 'claude-opus-4-6', 'thread' => $value]),
            fn () => $thread->update(['thread' => $value]),
            fn () => $thread->send(self::HI, ['thread' => $value]),
            fn () => $thread->sendStream(self::HI, ['thread' => $value]),
        ] as $route) {
            $error = $this->assertThrows(\InvalidArgumentException::class, $route);
            $this->assertSame('`thread` cannot be set on a message thread: the thread sets it for each request itself.', $error->getMessage());
        }

        $this->assertSame([], $thread->messages());
        $this->assertSame([], $this->transporter->getRequests());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function threadValues(): iterable
    {
        yield 'create' => [['type' => 'create']];

        yield 'continue' => [['type' => 'continue', 'previousMessageID' => 'msg_0']];
    }

    #[Test]
    public function testEveryRequestNamesTheHelper(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']),
            $this->reply('msg_3', 'Three'),
            $this->reply('msg_4', 'Four'),
        );
        $thread = $this->newThread(unsupportedRequestBehavior: 'continue_unthreaded');

        $thread->send(self::HI);
        iterator_to_array($thread->sendStream(self::MORE), false);
        $thread->send(self::MORE);
        $thread->send(self::MORE, requestOptions: ['extraHeaders' => ['X-Stainless-Helper' => 'mine, message-thread']]);

        $this->assertSame(
            [['type' => 'create'], self::continues('msg_1'), ['type' => 'create'], self::continues('msg_2'), null, null],
            array_map(fn (int $index) => $this->body($index)['thread'] ?? null, range(0, 5)),
        );
        $this->assertSame([...array_fill(0, 5, 'message-thread'), 'mine, message-thread'], $this->helperHeaders());
        $this->assertNull($thread->requestOptions()->extraHeaders ?? null);
    }

    #[Test]
    public function testOtherRequestOptionsGivenLaterReplaceTheEarlierValue(): void
    {
        $other = new MockClient;
        $other->addResponse($this->reply('msg_2', 'Two'));
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_3', 'Three'));
        $thread = $this->newThread();

        $thread->send(self::HI);
        $reply = $thread->send(self::MORE, requestOptions: ['transporter' => $other]);
        $thread->send(self::MORE);

        $this->assertSame('msg_2', $reply->id);
        $this->assertCount(1, $other->getRequests());
        $this->assertCount(2, $this->transporter->getRequests());
    }

    /**
     * @param array<string, mixed> $created
     * @param array<string, mixed> $changed
     */
    #[Test]
    #[DataProvider('refusedChanges')]
    public function testAChangedSystemOrToolsIsRefusedBeforeAnyRequest(array $created, array $changed, string $named, string $how): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(...$created);
        $thread->send(self::HI);

        if ('update()' === $how) {
            $thread->update($changed);
        }

        $e = $this->assertThrows(\LogicException::class, static fn () => $thread->send(self::MORE, 'update()' === $how ? [] : $changed));
        $this->assertSame(
            "Cannot change {$named} on a thread: the server keeps the `system` and `tools` the thread was created with. "
            .'To change them, start a new thread from `$thread->params()`.'
            .(array_key_exists('tools', $changed) ? ' To add or remove tools on this thread, send `tool_addition` or `tool_removal` blocks in a `system` message.' : ''),
            $e->getMessage(),
        );

        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame('msg_1', $thread->previousMessageId());
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));

        if ('update()' === $how) {
            $thread->update([...array_fill_keys(array_keys($changed), null), ...$created]);
        }
        $thread->send(self::MORE);

        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertArrayNotHasKey('system', $this->body(1));
        $this->assertArrayNotHasKey('tools', $this->body(1));
        $this->assertSame('msg_2', $thread->previousMessageId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<string, mixed>, string, string}>
     */
    public static function refusedChanges(): iterable
    {
        $changes = [
            'system' => [['system' => 'Be brief.'], ['system' => 'Be thorough.'], '`system`'],
            'tools' => [['tools' => [self::TOOL]], ['tools' => null], '`tools`'],
            'system and tools' => [['system' => 'Be brief.'], ['system' => 'Be thorough.', 'tools' => [self::TOOL]], '`system` and `tools`'],
        ];
        foreach ($changes as $name => [$created, $changed, $named]) {
            foreach (['update()', 'a field of the turn'] as $how) {
                yield "{$name}, by {$how}" => [$created, $changed, $named, $how];
            }
        }
    }

    /**
     * @param \Closure(): array{array<string, mixed>, \Closure(): void} $case
     */
    #[Test]
    #[DataProvider('modelsEditedInPlace')]
    public function testASystemOrToolsModelEditedInPlaceIsRefusedBeforeAnyRequest(string $field, \Closure $case, bool $streamed): void
    {
        [$created, $edit] = $case();
        $this->respond(
            $streamed ? self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop()) : $this->reply('msg_1', 'One'),
            $this->reply('msg_2', 'Two'),
        );
        $thread = $this->newThread(...$created);

        if ($streamed) {
            foreach ($thread->sendStream(self::HI) as $event) {
                if ('message_start' === $event->type) {
                    $edit();
                }
            }
        } else {
            $thread->send(self::HI);
            $edit();
        }

        $e = $this->assertThrows(\LogicException::class, static fn () => $thread->send(self::MORE));
        $this->assertStringStartsWith("Cannot change `{$field}` on a thread:", $e->getMessage());
        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame('msg_1', $thread->previousMessageId());

        $thread->send(self::MORE, $case()[0]);

        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    /**
     * @return iterable<string, array{string, \Closure(): array{array<string, mixed>, \Closure(): void}, bool}> the field, what makes the fields of a thread and an edit of a model in them, and whether the edit comes while the first reply streams
     */
    public static function modelsEditedInPlace(): iterable
    {
        $cases = [
            'a block of system' => ['system', static function () {
                $block = BetaTextBlockParam::with(text: 'Be brief.');

                return [['system' => [$block]], static function () use ($block) { $block->text = 'Be thorough.'; }];
            }],
            'a tool' => ['tools', static function () {
                $tool = BetaTool::with(inputSchema: ['type' => 'object'], name: 'get_weather');

                return [['tools' => [$tool]], static function () use ($tool) { $tool['description'] = 'The weather.'; }];
            }],
            'the definition of a runnable tool' => ['tools', static function () {
                $tool = BetaTool::with(inputSchema: ['type' => 'object'], name: 'get_weather');

                return [['tools' => [new BetaRunnableTool($tool, static fn () => 'ran')]], static function () use ($tool) { $tool->name = 'get_time'; }];
            }],
        ];
        foreach ($cases as $name => [$field, $case]) {
            yield "{$name}, after the first turn" => [$field, $case, false];

            yield "{$name}, while the first reply streams" => [$field, $case, true];
        }
    }

    #[Test]
    public function testTheSameToolsWithANullInsideCanBeGivenAgain(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $tools = [[...self::TOOL, 'description' => null]];
        $thread = $this->client->beta->messages->thread(maxTokens: 64, model: 'claude-opus-4-6', tools: $tools);
        $thread->send(self::HI);

        $thread->send(self::MORE, ['tools' => $tools]);

        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    #[Test]
    public function testAToolChangeInASystemMessageGoesOutOnTheContinueAsGiven(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $removal = ['role' => 'system', 'content' => [['type' => 'tool_removal', 'tool' => ['type' => 'tool_reference', 'name' => 'get_weather']]]];
        $thread = $this->newThread(tools: [self::TOOL]);
        $thread->send(self::HI);

        $thread->append($removal);
        $thread->send(self::MORE);

        $this->assertSame([self::continues('msg_1'), [$removal, self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
        $this->assertArrayNotHasKey('tools', $this->body(1));
    }

    #[Test]
    public function testASystemGivenToTheTurnThatCreatesTheThreadIsTheThreadsFromThenOn(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        $thread->send(self::HI, ['system' => 'Be brief.']);
        $thread->send(self::MORE);

        $this->assertSame('Be brief.', $this->body(0)['system']);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertArrayNotHasKey('system', $this->body(1));
        $this->assertSame('Be brief.', $thread->params()['system']);
    }

    #[Test]
    #[DataProvider('threadsThatContinueNothing')]
    public function testSystemAndToolsCanChangeWhereTheNextTurnContinuesNoThread(string $state): void
    {
        $this->respond(...[
            ...('a thread that went on without a thread' === $state ? [self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request'])] : []),
            'a thread whose stream ended early' === $state ? self::sse(self::start('msg_1'), ...self::text(0, 'One')) : $this->reply('msg_1', 'One'),
            $this->reply('msg_2', 'Two'),
        ]);
        $thread = $this->newThread(system: 'Be brief.', unsupportedRequestBehavior: 'continue_unthreaded');
        if ('a thread whose stream ended early' === $state) {
            iterator_to_array($thread->sendStream(self::HI), false);
        } elseif ('a thread before its first turn' !== $state) {
            $thread->send(self::HI);
        }
        if ('a fork' === $state) {
            $thread = $thread->fork();
        }
        $this->assertNull($thread->previousMessageId());
        $sent = count($this->transporter->getRequests());

        $thread->update(['system' => 'Be thorough.', 'tools' => [self::TOOL]]);
        $thread->send(self::MORE);

        $this->assertCount($sent + 1, $this->transporter->getRequests());
        $body = $this->body($sent);
        $this->assertSame('a thread that went on without a thread' === $state ? null : ['type' => 'create'], $body['thread'] ?? null);
        $this->assertSame(['Be thorough.', [self::TOOL]], [$body['system'], $body['tools']]);
        $this->assertEquals($this->wire(array_slice($thread->messages(), 0, -1)), $body['messages']);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function threadsThatContinueNothing(): iterable
    {
        foreach ([
            'a thread before its first turn',
            'a fork',
            'a thread that went on without a thread',
            'a thread whose stream ended early',
        ] as $state) {
            yield $state => [$state];
        }
    }

    #[Test]
    #[DataProvider('containers')]
    public function testTheContainerOfTheReplyIsSentOnLaterTurns(mixed $given, mixed $expected): void
    {
        $withContainer = self::message('msg_1', [['type' => 'text', 'text' => 'One']], 'end_turn');
        $withContainer['container'] = ['id' => 'container_1', 'expires_at' => '2026-01-01T00:00:00Z'];
        $this->respond(self::json(200, $withContainer), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread(container: $given);

        $thread->send(self::HI);
        $thread->send(self::MORE);

        $this->assertEquals($expected, $this->body(1)['container']);
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        if ($given instanceof BetaContainerParams) {
            $this->assertNull($given->id);
        }
    }

    /**
     * @return iterable<string, array{mixed, mixed}>
     */
    public static function containers(): iterable
    {
        yield 'none given' => [null, 'container_1'];

        yield 'an id given' => ['container_0', 'container_0'];

        yield 'an array without an id' => [['skills' => []], ['id' => 'container_1', 'skills' => []]];

        yield 'a model without an id' => [BetaContainerParams::with(skills: []), ['id' => 'container_1', 'skills' => []]];

        yield 'an array with an id' => [['id' => 'container_0', 'skills' => []], ['id' => 'container_0', 'skills' => []]];
    }

    #[Test]
    public function testTheThreadsBetaJoinsTheCallersBetasOnce(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'), $this->reply('msg_3', 'Three'));
        $thread = $this->newThread(betas: ['files-api-2025-04-14', self::THREADS_BETA]);

        $thread->send(self::HI);
        $thread->send(self::MORE, ['betas' => [AnthropicBeta::MESSAGE_THREADS_2026_08_12]]);
        $thread->send(self::MORE, ['betas' => null]);

        $this->assertEqualsCanonicalizing(['files-api-2025-04-14', self::THREADS_BETA], $this->betas(0));
        $this->assertSame([self::THREADS_BETA], $this->betas(1));
        $this->assertSame([self::THREADS_BETA], $this->betas(2));
    }

    // -------------------------------------------------------------------------
    // Params, fork, output format, providers
    // -------------------------------------------------------------------------

    #[Test]
    public function testThreadTakesEveryRequestParameterOfCreate(): void
    {
        $update = 'Update thread() in src/Services/Beta/MessagesService.php: its parameter list, its doc comment and the fields that it passes to the message thread.';
        $names = static fn (string $method) => array_map(
            static fn (\ReflectionParameter $parameter) => $parameter->getName(),
            (new \ReflectionMethod(MessagesService::class, $method))->getParameters(),
        );
        $fields = array_values(array_diff($names('create'), ['thread', 'requestOptions']));

        $this->assertSame(
            [],
            array_values(array_diff($fields, $names('thread'))),
            "create() takes request parameters that thread() does not take. {$update}",
        );
        $this->assertSame(
            [],
            array_values(array_diff($names('thread'), $fields, ['unsupportedRequestBehavior', 'requestOptions'])),
            "thread() takes parameters that create() does not take. {$update}",
        );

        foreach (array_diff($fields, ['maxTokens', 'model']) as $name) {
            $type = (new \ReflectionParameter([MessagesService::class, 'thread'], $name))->getType();
            $types = array_map(
                static fn (\ReflectionNamedType $named) => $named->getName(),
                $type instanceof \ReflectionUnionType ? array_filter($type->getTypes(), static fn ($named) => $named instanceof \ReflectionNamedType) : ($type instanceof \ReflectionNamedType ? [$type] : []),
            );
            $value = match (true) {
                in_array('array', $types, true) => 'messages' === $name ? [self::HI] : ['given' => $name],
                in_array('string', $types, true) => "given {$name}",
                in_array('int', $types, true) => 7,
                in_array('float', $types, true) => 0.5,
                default => $this->fail("No value of a simple type can be given for `{$name}`. Give this test a value for it."),
            };

            // @phpstan-ignore argument.type
            $thread = $this->client->beta->messages->thread(...['maxTokens' => 64, 'model' => 'claude-opus-4-6', $name => $value]);

            $this->assertSame($value, $thread->params()[$name] ?? null, "thread() drops `{$name}`. {$update}");
        }
    }

    #[Test]
    public function testEveryParameterGivenToThreadIsSent(): void
    {
        $this->respond($this->reply('msg_1', 'One'));

        $thread = $this->client->beta->messages->thread(
            maxTokens: 64,
            model: 'claude-opus-4-6',
            messages: [self::HI],
            inferenceGeo: null,
            metadata: ['userID' => 'user_1'],
            serviceTier: 'auto',
            stopSequences: ['END'],
            userProfileID: 'profile_1',
        );
        $thread->send();

        $this->assertArrayNotHasKey('inferenceGeo', $thread->params());
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::HI],
                'model' => 'claude-opus-4-6',
                'metadata' => ['user_id' => 'user_1'],
                'service_tier' => 'auto',
                'stop_sequences' => ['END'],
                'thread' => ['type' => 'create'],
            ],
            $this->body(0),
        );
        $this->assertSame('profile_1', $this->request(0)->getHeaderLine('anthropic-user-profile-id'));
    }

    #[Test]
    public function testParamsRebuildAThread(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'));
        $tool = new BetaRunnableTool(self::TOOL, static fn () => 'sunny');
        $thread = $this->newThread(system: 'Be brief.', tools: [$tool]);
        $thread->send(self::HI);
        $thread->update(['stopSequences' => ['END']]);
        $thread->append(self::MORE);

        $params = $thread->params();
        // @phpstan-ignore argument.type
        $rebuilt = $this->client->beta->messages->thread(...$params);
        $rebuilt->send();

        $this->assertSame([$tool], $params['tools']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->wire($params['messages']));
        $this->assertSame(
            [
                'max_tokens' => 64,
                'messages' => [self::HI, self::assistant('One'), self::MORE],
                'model' => 'claude-opus-4-6',
                'stop_sequences' => ['END'],
                'system' => 'Be brief.',
                'thread' => ['type' => 'create'],
                'tools' => [self::TOOL],
            ],
            $this->body(1),
        );
    }

    #[Test]
    public function testParamsRebuildAThreadWithTheSameUnsupportedRequestBehavior(): void
    {
        $unsupported = self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']);
        $this->respond($unsupported, $this->reply('msg_1', 'One'), $unsupported);

        // @phpstan-ignore argument.type
        $rebuilt = $this->client->beta->messages->thread(...$this->newThread(unsupportedRequestBehavior: 'continue_unthreaded')->params());
        $this->assertSame('msg_1', $rebuilt->send(self::HI)->id);
        $this->assertSame(['max_tokens' => 64, 'messages' => [self::HI], 'model' => 'claude-opus-4-6'], $this->body(1));

        // @phpstan-ignore argument.type
        $rebuiltDefault = $this->client->beta->messages->thread(...$this->newThread()->params());
        $this->assertThrows(BadRequestException::class, static fn () => $rebuiltDefault->send(self::HI));
        $this->assertCount(3, $this->transporter->getRequests());
    }

    #[Test]
    public function testAForkIsIndependent(): void
    {
        $this->respond($this->reply('msg_1', 'One'), $this->reply('msg_2', 'Two'), $this->reply('msg_3', 'Three'), $this->reply('msg_4', 'Four'));
        $thread = $this->newThread(system: 'Be brief.', requestOptions: ['extraHeaders' => ['X-One' => 'creation']]);
        $thread->send(self::HI);
        $thread->append(self::MORE);

        $fork = $thread->fork();
        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertNull($fork->previousMessageId());
        $this->assertSame($this->wire($thread->messages()), $this->wire($fork->messages()));

        $fork->update(['system' => 'Be thorough.']);
        $fork->send(['role' => 'user', 'content' => 'Fork']);
        $thread->send();
        $fork->send(['role' => 'user', 'content' => 'Fork again']);

        $this->assertSame(['type' => 'create'], $this->body(1)['thread']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, ['role' => 'user', 'content' => 'Fork']], $this->body(1)['messages']);
        $this->assertSame('Be thorough.', $this->body(1)['system']);
        $this->assertSame('creation', $this->request(1)->getHeaderLine('X-One'));
        $this->assertSame(self::continues('msg_1'), $this->body(2)['thread']);
        $this->assertSame([self::MORE], $this->body(2)['messages']);
        $this->assertSame(self::continues('msg_2'), $this->body(3)['thread']);
        $this->assertCount(4, $thread->messages());
        $this->assertCount(7, $fork->messages());
    }

    #[Test]
    public function testAForkKeepsTheUnsupportedRequestBehaviorAndStaysUnthreaded(): void
    {
        $this->respond(
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']),
            $this->reply('msg_1', 'One'),
            $this->reply('msg_2', 'Two'),
            self::error(400, 'invalid_request_error', ['error_code' => 'thread_unsupported_request']),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread(unsupportedRequestBehavior: 'continue_unthreaded');
        $early = $thread->fork();
        $thread->send(self::HI);

        $thread->fork()->send(self::MORE);
        $early->send(self::HI);

        $this->assertArrayNotHasKey('thread', $this->body(2));
        $this->assertSame([], $this->betas(2));
        $this->assertSame(['type' => 'create'], $this->body(3)['thread']);
        $this->assertArrayNotHasKey('thread', $this->body(4));
    }

    #[Test]
    public function testAParsedTurnThreadsLikeAnyOther(): void
    {
        $this->respond($this->reply('msg_1', '{"city": "SF"}'), $this->reply('msg_2', '{"city": "NYC"}'));
        $thread = $this->newThread(outputConfig: ['format' => ThreadedCity::class]);

        $first = $thread->send(self::HI);
        $thread->append($first);
        $second = $thread->send(self::MORE);

        foreach ([[$first, 'SF'], [$second, 'NYC']] as [$reply, $city]) {
            $block = $reply->content[0];
            $this->assertInstanceOf(BetaTextBlock::class, $block);
            $parsed = $block->parsed;
            $this->assertInstanceOf(ThreadedCity::class, $parsed);
            $this->assertSame($city, $parsed->city);
        }
        $this->assertSame(self::continues('msg_1'), $this->body(1)['thread']);
        $this->assertSame([self::MORE], $this->body(1)['messages']);
        foreach ([0, 1] as $index) {
            $format = $this->body($index)['output_config'];
            $this->assertIsArray($format);
            $this->assertIsArray($format['format']);
            $this->assertSame('json_schema', $format['format']['type']);
            $this->assertArrayNotHasKey('output_format', $this->body($index));
            $this->assertSame([self::THREADS_BETA], $this->betas($index));
        }
        $this->assertSame([self::HI, self::assistant('{"city": "SF"}'), self::MORE, self::assistant('{"city": "NYC"}')], $this->wire($thread->messages()));
    }

    /**
     * @param \Closure(MockClient): Client $factory
     */
    #[Test]
    #[DataProvider('platformClients')]
    public function testThreadsAreRefusedOnPlatformsWithoutThem(\Closure $factory, bool $supported): void
    {
        $this->respond($this->reply('msg_1', 'One'));
        $client = $factory($this->transporter);

        try {
            $thread = $client->beta->messages->thread(maxTokens: 64, model: 'claude-opus-4-6');
            $thread->send(self::HI);
            $this->assertTrue($supported, 'Expected the thread to be refused');
            $this->assertSame(['type' => 'create'], $this->body(0)['thread']);
            $this->assertContains(self::THREADS_BETA, $this->betas(0));
        } catch (AnthropicException $e) {
            $this->assertFalse($supported, $e->getMessage());
            $this->assertSame([], $this->transporter->getRequests());
        }
    }

    // -------------------------------------------------------------------------
    // Streams
    // -------------------------------------------------------------------------

    #[Test]
    public function testAStreamedTurnCreatesThenContinues(): void
    {
        $this->respond(
            self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop()),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread(system: 'Be brief.');

        $types = [];
        foreach ($thread->sendStream(self::HI) as $event) {
            $types[] = $event->type;
        }
        $this->assertSame('msg_1', $thread->previousMessageId());
        $this->assertSame('One', $thread->lastMessage()?->content[0]['text'] ?? null);
        iterator_to_array($thread->sendStream(self::MORE), false);
        $thread->send(self::MORE);

        $this->assertSame(['message_start', 'content_block_start', 'content_block_delta', 'content_block_stop', 'message_delta', 'message_stop'], $types);
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::HI], 'model' => 'claude-opus-4-6', 'system' => 'Be brief.', 'thread' => ['type' => 'create'], 'stream' => true],
            $this->body(0),
        );
        $this->assertSame(
            ['max_tokens' => 64, 'messages' => [self::MORE], 'model' => 'claude-opus-4-6', 'thread' => self::continues('msg_1'), 'stream' => true],
            $this->body(1),
        );
        $this->assertSame([self::THREADS_BETA], $this->betas(1));
        $this->assertArrayNotHasKey('stream', $this->body(2));
        $this->assertSame(self::continues('msg_2'), $this->body(2)['thread']);
    }

    #[Test]
    public function testAStreamIsReplayedWhenTheThreadIsGone(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);

        iterator_to_array($thread->sendStream(self::MORE), false);

        $this->assertSame(['type' => 'create'], $this->body(2)['thread']);
        $this->assertTrue($this->body(2)['stream']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->body(2)['messages']);
        $this->assertSame('msg_2', $thread->previousMessageId());
    }

    #[Test]
    #[DataProvider('waysToLeaveAStream')]
    public function testAStreamThatIsNeverReadEndsItsTurn(bool $close): void
    {
        $this->respond(self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop()), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        $events = $thread->sendStream(self::HI);
        if ($close) {
            $events->close();
        } else {
            unset($events);
        }
        $thread->send();

        $this->assertSame([self::HI], $this->body(1)['messages']);
        $this->assertSame(['type' => 'create'], $this->body(1)['thread']);
    }

    /**
     * @param list<string> $events
     * @param list<array<string, mixed>> $recorded the content of the partial reply in the history
     */
    #[Test]
    #[DataProvider('streamsThatEndEarly')]
    public function testAStreamThatEndsEarlyRecordsWhatFinishedAndSendsItAsRecorded(array $events, array $recorded): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2'), ...$events),
            $this->reply('msg_3', 'Three'),
            $this->reply('msg_4', 'Four'),
        );
        $thread = $this->newThread(tools: [self::TOOL]);
        $thread->send(self::HI);

        iterator_to_array($thread->sendStream(self::MORE), false);

        $partial = static fn (array $content) => [] === $content ? [] : [['role' => 'assistant', 'content' => $content]];
        $last = ['role' => 'user', 'content' => 'Last'];
        $this->assertNull($thread->previousMessageId());
        $this->assertEquals([self::HI, self::assistant('One'), self::MORE, ...$partial($recorded)], $this->wire($thread->messages()));
        $this->assertSame([] === $recorded ? 'msg_1' : 'msg_2', $thread->lastMessage()?->id, 'The last message is the partial reply, if any part was kept');
        $this->assertEquals([] === $recorded ? self::assistant('One')['content'] : $recorded, $this->wire($thread->lastMessage()->content));

        $thread->send($last);
        $this->assertSame(['type' => 'create'], $this->body(2)['thread']);
        $this->assertEquals([self::HI, self::assistant('One'), self::MORE, ...$partial($recorded), $last], $this->body(2)['messages']);
        $this->assertSame([self::TOOL], $this->body(2)['tools']);
        $this->assertEquals(
            [self::HI, self::assistant('One'), self::MORE, ...$partial($recorded), $last, self::assistant('Three')],
            $this->wire($thread->messages()),
        );
        $thread->send(self::MORE);
        $this->assertSame(self::continues('msg_3'), $this->body(3)['thread']);
    }

    /**
     * @param list<string> $events
     */
    #[Test]
    #[DataProvider('streamsThatEndEarly')]
    public function testSendWithNoMessagesAfterAStreamThatEndedEarlySendsTheTurnAgain(array $events): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2', 'pause_turn'), ...$events),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);
        iterator_to_array($thread->sendStream([self::MORE, self::MORE]), false);

        $thread->send();

        $this->assertSame(['type' => 'create'], $this->body(2)['thread']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::MORE], $this->body(2)['messages']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::MORE, self::assistant('Three')], $this->wire($thread->messages()));
        $this->assertSame('msg_3', $thread->previousMessageId());
    }

    /**
     * @param list<string> $events
     */
    #[Test]
    #[DataProvider('streamsThatEndEarly')]
    public function testAForkAfterAStreamThatEndedEarlySendsTheTurnAgainLikeTheThread(array $events): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2'), ...$events),
            $this->reply('msg_3', 'Three'),
            self::sse(self::start('msg_4'), ...self::text(0, 'Four'), ...self::stop()),
            $this->reply('msg_5', 'Five'),
            $this->reply('msg_6', 'Six'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);
        iterator_to_array($thread->sendStream(self::MORE), false);
        $history = $this->wire($thread->messages());

        $fork = $thread->fork();
        $this->assertSame($history, $this->wire($fork->messages()));
        $fork->send();
        iterator_to_array($thread->fork()->fork()->sendStream(), false);
        $this->assertSame($history, $this->wire($thread->messages()));
        $thread->send();
        $thread->fork()->send();

        foreach ([2, 3, 4] as $index) {
            $this->assertSame([['type' => 'create'], [self::HI, self::assistant('One'), self::MORE]], [$this->body($index)['thread'], $this->body($index)['messages']]);
        }
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::assistant('Three')], $this->wire($fork->messages()));
        $this->assertSame('msg_3', $fork->previousMessageId());
        $this->assertSame(
            [['type' => 'create'], [self::HI, self::assistant('One'), self::MORE, self::assistant('Five')]],
            [$this->body(5)['thread'], $this->body(5)['messages']],
            'A whole reply stays',
        );
    }

    /**
     * @param list<string> $events
     */
    #[Test]
    #[DataProvider('streamsThatEndEarly')]
    public function testAForkAfterAStreamThatEndedEarlySendsThePartialReplyAheadOfANewMessage(array $events): void
    {
        $this->respond($this->reply('msg_1', 'One'), self::sse(self::start('msg_2'), ...$events), $this->reply('msg_3', 'Three'), $this->reply('msg_4', 'Four'));
        $thread = $this->newThread();
        $thread->send(self::HI);
        iterator_to_array($thread->sendStream(self::MORE), false);
        $history = $this->wire($thread->messages());

        $thread->fork()->send(self::HI);
        $appended = $thread->fork();
        $appended->append(self::HI);
        $appended->send();

        foreach ([2, 3] as $index) {
            $this->assertEquals([['type' => 'create'], [...$history, self::HI]], [$this->body($index)['thread'], $this->body($index)['messages']]);
        }
    }

    /**
     * @return iterable<string, array{list<string>, list<array<string, mixed>>}>
     */
    public static function streamsThatEndEarly(): iterable
    {
        $call = ['type' => 'tool_use', 'id' => 'toolu_1', 'input' => ['location' => 'SF'], 'name' => 'get_weather'];
        $toolUse = [
            self::event('content_block_start', ['index' => 1, 'content_block' => ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => (object) []]]),
            self::event('content_block_delta', ['index' => 1, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"location": "SF"}']]),
        ];

        yield 'in the middle of a text block' => [[...self::text(0, 'One', stop: false)], [['type' => 'text', 'text' => 'One']]];

        yield 'with a text block that has no text yet' => [[...self::text(0, 'One'), ...self::text(1, '', stop: false)], [['type' => 'text', 'text' => 'One']]];

        yield 'in the middle of a tool call' => [[...self::text(0, 'One'), ...$toolUse], [['type' => 'text', 'text' => 'One']]];

        yield 'after a finished tool call' => [
            [...self::text(0, 'One'), ...$toolUse, self::blockStop(1)],
            [['type' => 'text', 'text' => 'One'], $call],
        ];

        yield 'before any content' => [[], []];
    }

    /**
     * @param list<string> $events
     */
    #[Test]
    #[DataProvider('streamsThatEndBeforeTheReplyStarts')]
    public function testAStreamThatEndsBeforeTheReplyStartsTakesItsMessagesBack(array $events): void
    {
        $this->respond($this->reply('msg_1', 'One'), self::sse(...$events), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();
        $thread->send(self::HI);

        $seen = iterator_to_array($thread->sendStream(self::MORE), false);

        $this->assertSame([], array_values(array_filter($seen, static fn (mixed $event) => 'ping' !== ($event['type'] ?? null))));
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));
        $this->assertSame('msg_1', $thread->lastMessage()?->id);
        $this->assertSame('msg_1', $thread->previousMessageId(), 'No part of a reply arrived, so the thread is as it was before the turn');

        $thread->send(self::MORE);

        $this->assertSame($this->body(1)['messages'], $this->body(2)['messages']);
        $this->assertSame([self::MORE], $this->body(2)['messages']);
        $this->assertSame(self::continues('msg_1'), $this->body(2)['thread']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::assistant('Two')], $this->wire($thread->messages()));
    }

    #[Test]
    #[DataProvider('waysToLeaveAStream')]
    public function testAStreamLeftBeforeTheReplyStartsTakesItsMessagesBack(bool $close): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::event('an_event_of_a_later_api'), self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);

        $events = $thread->sendStream(self::MORE);
        $this->assertNotSame('message_start', $events->getIterator()->current()['type']);
        if ($close) {
            $events->close();
        } else {
            unset($events);
        }

        $this->assertSame('msg_1', $thread->previousMessageId());
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));
        $thread->send(self::MORE);
        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(2)['thread'], $this->body(2)['messages']]);
    }

    #[Test]
    public function testAStreamThatFailsAfterTheReplyStartedKeepsItsMessages(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(...[self::start('msg_2'), ...self::text(0, 'Tw', stop: false), self::overloaded()]),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);

        $this->assertThrows(APIException::class, static fn () => iterator_to_array($thread->sendStream(self::MORE), false));
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::assistant('Tw')], $this->wire($thread->messages()));
        $thread->send(self::HI);

        $this->assertSame(
            [['type' => 'create'], [self::HI, self::assistant('One'), self::MORE, self::assistant('Tw'), self::HI]],
            [$this->body(2)['thread'], $this->body(2)['messages']],
        );
    }

    #[Test]
    public function testACallRejectedAfterAStreamThatEndedEarlyLeavesThePartialReplyAsItWas(): void
    {
        $this->respond(
            $this->reply('msg_1', 'One'),
            self::sse(self::start('msg_2'), ...self::text(0, 'Tw', stop: false)),
            self::error(400, 'invalid_request_error'),
            $this->reply('msg_3', 'Three'),
        );
        $thread = $this->newThread();
        $thread->send(self::HI);
        iterator_to_array($thread->sendStream(self::MORE), false);

        $this->assertThrows(BadRequestException::class, static fn () => $thread->send(self::HI));
        $this->assertSame([self::HI, self::assistant('One'), self::MORE, self::assistant('Tw')], $this->wire($thread->messages()));
        $this->assertSame('msg_2', $thread->lastMessage()?->id);
        $thread->send();

        $this->assertSame([['type' => 'create'], [self::HI, self::assistant('One'), self::MORE]], [$this->body(3)['thread'], $this->body(3)['messages']]);
    }

    #[Test]
    #[DataProvider('waysToLeaveAStream')]
    public function testAStreamReadInPartKeepsTheThreadBusyUntilItIsClosedOrReleased(bool $close): void
    {
        $response = self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop());
        $this->respond($response, $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        $events = $thread->sendStream(self::HI);
        $iterator = $events->getIterator();
        $iterator->current();
        $iterator->next();
        $iterator->next();

        $e = $this->assertThrows(\LogicException::class, static fn () => $thread->send(self::MORE));
        $this->assertSame('Another turn is in progress on this message thread. Wait for it to end, or close() its stream.', $e->getMessage());
        $this->assertThrows(\LogicException::class, static fn () => $thread->sendStream(self::MORE));
        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame([self::HI], $thread->messages());
        $this->assertTrue($response->getBody()->isReadable());

        if ($close) {
            $events->close();
        } else {
            unset($events, $iterator);
        }

        $this->assertFalse($response->getBody()->isReadable());
        $this->assertNull($thread->previousMessageId());
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));
        $thread->send(self::MORE);

        $this->assertSame(['type' => 'create'], $this->body(1)['thread']);
        $this->assertSame([self::HI, self::assistant('One'), self::MORE], $this->body(1)['messages']);
    }

    /**
     * @return iterable<string, array{bool}> whether the stream is closed, or its last reference goes
     */
    public static function waysToLeaveAStream(): iterable
    {
        yield 'closed' => [true];

        yield 'released' => [false];
    }

    #[Test]
    public function testClosingAStreamThatEndedChangesNothing(): void
    {
        $this->respond(self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop()), $this->reply('msg_2', 'Two'));
        $thread = $this->newThread();

        $events = $thread->sendStream(self::HI);
        $this->assertCount(6, iterator_to_array($events, false));
        $events->close();
        $events->close();

        $this->assertSame([], iterator_to_array($events, false));
        $this->assertSame('msg_1', $thread->previousMessageId());
        $this->assertSame([self::HI, self::assistant('One')], $this->wire($thread->messages()));
        $thread->send(self::MORE);
        $this->assertSame([self::continues('msg_1'), [self::MORE]], [$this->body(1)['thread'], $this->body(1)['messages']]);
    }

    #[Test]
    public function testClosingAStreamAgainLeavesALaterTurnInProgress(): void
    {
        $this->respond(
            self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop()),
            self::sse(self::start('msg_2'), ...self::text(0, 'Two'), ...self::stop()),
        );
        $thread = $this->newThread();

        $first = $thread->sendStream(self::HI);
        foreach ($first as $event) {
            if ('content_block_delta' === $event->type) {
                break;
            }
        }
        $first->close();
        $history = $this->wire($thread->messages());
        $first->close();

        $this->assertSame([], iterator_to_array($first, false));
        $this->assertSame([self::HI, self::assistant('One')], $history);
        $this->assertSame($history, $this->wire($thread->messages()));

        $second = $thread->sendStream(self::MORE);
        $first->close();

        $this->assertThrows(\LogicException::class, static fn () => $thread->send(self::MORE));
        $this->assertCount(6, iterator_to_array($second, false));
        $this->assertSame('msg_2', $thread->previousMessageId());
        $this->assertSame([...$history, self::MORE, self::assistant('Two')], $this->wire($thread->messages()));
    }

    #[Test]
    public function testAStreamLeftEarlyClosesTheResponse(): void
    {
        $response = self::sse(self::start('msg_1'), ...self::text(0, 'One'), ...self::stop());
        $this->respond($response);

        foreach ($this->newThread()->sendStream(self::HI) as $_) {
            break;
        }

        $this->assertFalse($response->getBody()->isReadable());
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @return array{role: string, content: list<array<string, mixed>>}
     */
    private static function assistant(string $text): array
    {
        return ['role' => 'assistant', 'content' => [['type' => 'text', 'text' => $text]]];
    }

    /**
     * @return array{role: string, content: list<array<string, mixed>>} a user message with a cache breakpoint
     */
    private static function marked(string $text): array
    {
        return ['role' => 'user', 'content' => [['type' => 'text', 'text' => $text, 'cache_control' => self::EPHEMERAL]]];
    }

    /**
     * @return array{role: string, content: list<array<string, mixed>>} the message of marked() without its cache breakpoint
     */
    private static function unmarked(string $text): array
    {
        return ['role' => 'user', 'content' => [['type' => 'text', 'text' => $text]]];
    }

    private function reply(string $id, string $text, string $stopReason = 'end_turn'): ResponseInterface
    {
        return self::json(200, self::message($id, [['type' => 'text', 'text' => $text]], $stopReason));
    }

    /**
     * @param array<string, mixed>|null $details
     */
    private static function error(int $status, string $type, ?array $details = null, string $message = 'The request was rejected.'): ResponseInterface
    {
        $error = ['type' => $type, 'message' => $message];
        if (null !== $details) {
            $error['details'] = $details;
        }

        return self::json($status, ['type' => 'error', 'error' => $error]);
    }

    private static function notFound(): ResponseInterface
    {
        return self::error(404, 'not_found_error', ['error_code' => 'thread_not_found']);
    }

    private static function overloaded(): string
    {
        return self::event('error', ['error' => ['type' => 'overloaded_error', 'message' => 'Overloaded']]);
    }

    private static function blockStop(int $index): string
    {
        return self::event('content_block_stop', ['index' => $index]);
    }

    /**
     * @return list<string>
     */
    private static function text(int $index, string $text, bool $stop = true): array
    {
        return [
            self::event('content_block_start', ['index' => $index, 'content_block' => ['type' => 'text', 'text' => '']]),
            ...('' === $text ? [] : [self::event('content_block_delta', ['index' => $index, 'delta' => ['type' => 'text_delta', 'text' => $text]])]),
            ...($stop ? [self::blockStop($index)] : []),
        ];
    }
}
