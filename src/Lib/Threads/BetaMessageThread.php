<?php

declare(strict_types=1);

namespace Anthropic\Lib\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaFallbackMessageIterationUsage;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaStopReason;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Implementation\TracedStream;
use Anthropic\Lib\Helpers\StainlessHelperHeader;
use Anthropic\Lib\Streaming\MessageAccumulator;
use Anthropic\Lib\Tools\BetaRunnableTool;
use Anthropic\Lib\Tools\BetaToolRunner;
use Anthropic\RequestOptions;

/**
 * A conversation that the API keeps between requests, so that each turn sends only the messages
 * that are new. Create one with `$client->beta->messages->thread(...)`. A thread runs one turn at
 * a time.
 *
 * ```php
 * $thread = $client->beta->messages->thread(maxTokens: 1024, model: 'claude-opus-5-5');
 * $reply = $thread->send(['role' => 'user', 'content' => 'Hello']);
 * $reply = $thread->send(['role' => 'user', 'content' => 'And again']);
 * ```
 *
 * @phpstan-import-type BetaMessageParamVariants from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 *
 * @phpstan-type Message array<string, mixed>|BaseModel
 * @phpstan-type Recorded array<string, mixed>|BaseModel|PartialReply
 * @phpstan-type CreateOnly array{fields: array{system: mixed, tools: mixed}, json: array{system: string, tools: string}}
 * @phpstan-type StreamEvent BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent
 */
final class BetaMessageThread
{
    /** A `continue` rejected with one of these is sent again as a `create`. */
    private const REPLAY_ERROR_CODES = ['thread_not_found', 'thread_already_continued', 'thread_continue_in_flight'];

    /** @var array<string, mixed> every field of create() except `messages` and `thread`, by camelCase name */
    private array $fields;

    private RequestOptions $requestOptions;

    /** @var list<Recorded> the messages that were sent, and each reply as it arrived: a `BetaMessage`, or a `PartialReply` */
    private array $stored = [];

    /** @var list<Recorded> the messages that the next turn sends */
    private array $staged = [];

    private Anchor|Unanchored $next = Unanchored::CREATE;

    /** @var list<Message>|null the messages appended during the turn in progress, or `null` when no turn is in progress */
    private ?array $deferred = null;

    /** How many messages at the end of `$staged` were given to the turn in progress rather than appended. */
    private int $givenToTurn = 0;

    /**
     * @internal use `$client->beta->messages->thread(...)`
     *
     * @param array<string, mixed> $params the fields of create() by camelCase name, with `messages` as the seed
     * @param RequestOpts|null $requestOptions
     *
     * @throws \InvalidArgumentException if `$params` sets `thread`
     */
    public function __construct(
        private Client $client,
        array $params,
        RequestOptions|array|null $requestOptions = null,
        private UnsupportedRequestBehavior $unsupportedRequestBehavior = UnsupportedRequestBehavior::ERROR,
    ) {
        if (!$client->supportsMessageThreads()) {
            throw new AnthropicException('Message threads are not available on '.$client::class.'.');
        }
        self::rejectThreadParam($params);

        // @phpstan-ignore argument.type
        $this->stage(self::messageList($params['messages'] ?? null));
        unset($params['messages']);

        $this->fields = $params;
        $this->requestOptions = RequestOptions::parse($requestOptions);
    }

    /**
     * The whole history: every message that was sent, every reply, and the messages staged for
     * the next turn.
     *
     * @return list<Message>
     */
    public function messages(): array
    {
        return array_map(self::messageParam(...), [...$this->stored, ...$this->staged, ...$this->deferred ?? []]);
    }

    /**
     * The ID of the reply that the next turn continues from, or `null` when the next turn sends
     * the whole history.
     */
    public function previousMessageId(): ?string
    {
        return $this->next instanceof Anchor ? $this->next->previousMessageId : null;
    }

    /**
     * The last reply that the thread recorded, or `null` when the history holds none.
     */
    public function lastMessage(): ?BetaMessage
    {
        return self::replyOf($this->stored[$this->answered() - 1] ?? null);
    }

    /**
     * The thread's request fields, with `messages` set to the whole history, and its
     * unsupported-request behavior.
     *
     * @return array<string, mixed> the named parameters of `$client->beta->messages->thread(...)`, with `unsupportedRequestBehavior` as an `UnsupportedRequestBehavior`
     */
    public function params(): array
    {
        return [...$this->fields, 'messages' => $this->messages(), 'unsupportedRequestBehavior' => $this->unsupportedRequestBehavior];
    }

    /**
     * Stages messages for the next turn without sending them. Messages appended while a turn is
     * in progress are staged when the turn ends.
     *
     * @param array<string, mixed>|list<Message>|BetaMessageParamVariants|BetaMessage ...$messages each argument is one message, or a list of messages
     */
    public function append(array|BaseModel ...$messages): void
    {
        $messages = array_merge(...array_map(self::messageList(...), array_values($messages)));
        if (null === $this->deferred) {
            $this->stage($messages);
        } else {
            array_push($this->deferred, ...$messages);
        }
    }

    /**
     * Sends the messages staged with append(), followed by `$messages`, as one turn and returns
     * the reply.
     *
     * @param array<string, mixed>|list<Message>|BaseModel|null $messages one message, or a list of messages
     * @param array<string, mixed> $params Fields of create() by camelCase name, except `messages` and `thread`, for this turn only. A field set to `null` is left out of this turn's request.
     * @param RequestOpts|null $requestOptions request options for this turn only
     *
     * @throws \InvalidArgumentException if `$params` sets `thread`
     * @throws \LogicException if another turn is in progress on this thread, or if the turn would change the `system` or `tools` of the thread that it continues
     * @throws APIException
     */
    public function send(
        array|BaseModel|null $messages = null,
        array $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BetaMessage {
        $this->startTurn($messages, $params);

        try {
            [$reply, $createdWith] = $this->request(
                // @phpstan-ignore argument.type
                fn (array $arguments) => $this->client->beta->messages->create(...$arguments),
                $params,
                $requestOptions,
            );
            $this->recordReply($reply, $createdWith);

            return $reply;
        } finally {
            $this->endTurn();
        }
    }

    /**
     * Sends the next turn like send() and returns the events of the reply as they arrive. The
     * turn is in progress until the stream ends or is closed with close().
     *
     * @param array<string, mixed>|list<Message>|BaseModel|null $messages one message, or a list of messages
     * @param array<string, mixed> $params Fields of create() by camelCase name, except `messages` and `thread`, for this turn only. A field set to `null` is left out of this turn's request.
     * @param RequestOpts|null $requestOptions request options for this turn only
     *
     * @return BaseStream<StreamEvent> the raw stream events of the reply
     *
     * @throws \InvalidArgumentException if `$params` sets `thread`
     * @throws \LogicException if another turn is in progress on this thread, or if the turn would change the `system` or `tools` of the thread that it continues
     * @throws APIException
     */
    public function sendStream(
        array|BaseModel|null $messages = null,
        array $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream {
        $this->startTurn($messages, $params);

        try {
            [$events, $createdWith] = $this->request(
                // @phpstan-ignore argument.type
                fn (array $arguments) => $this->client->beta->messages->createStream(...$arguments),
                $params,
                $requestOptions,
            );
        } catch (\Throwable $e) {
            $this->endTurn();

            throw $e;
        }

        $stream = $this->forward($events, $createdWith);

        // A generator that never ran skips its `finally`, so valid() runs it up to the first event. One that has ended cannot be iterated.
        return new TracedStream($events, $stream->valid() ? $stream : (static fn () => yield from [])());
    }

    /**
     * Changes the thread's request fields and request options for every later turn. `system` and
     * `tools` cannot change once a turn has created the thread.
     *
     * @param array<string, mixed> $params Fields of create() by camelCase name, except `messages` and `thread`. A field set to `null` is removed.
     * @param RequestOpts|null $requestOptions
     *
     * @throws \InvalidArgumentException if `$params` sets `thread`
     */
    public function update(array $params, RequestOptions|array|null $requestOptions = null): void
    {
        self::rejectThreadParam($params);
        $this->fields = self::overlay($this->fields, $params);
        $this->requestOptions = RequestOptions::parse($this->requestOptions, $requestOptions);
    }

    /**
     * Returns an independent thread with this thread's history, request fields, request options
     * and unsupported-request behavior. It sends no request.
     */
    public function fork(): self
    {
        $fork = clone $this;
        $fork->deferred = null;
        $fork->stage($this->deferred ?? []);
        $fork->startNewThread();

        return $fork;
    }

    /**
     * Creates a tool runner that runs the tool loop over this thread, with the `BetaRunnableTool`s
     * of `tools`. It sends no request.
     *
     * @param int|null $maxIterations the most turns the runner sends; unlimited when `null`
     */
    public function toolRunner(?int $maxIterations = null): BetaToolRunner
    {
        return BetaToolRunner::overThread($this->client, $this, $maxIterations);
    }

    /**
     * Takes the history from `$messages`. A list that begins with what was sent keeps the thread
     * and stages the rest. Any other list replaces the history, and the next turn starts a new
     * thread with it.
     *
     * @internal
     *
     * @param list<Message> $messages
     */
    public function setMessages(array $messages): void
    {
        $this->assertIdle();

        $sent = array_map(self::messageParam(...), $this->stored);
        $given = array_slice(array_map(self::messageParam(...), $messages), 0, count($sent));
        if ($given !== $sent && self::json($given) !== self::json($sent)) {
            $this->stored = [];
            $this->startNewThread();
        }

        $this->staged = [];
        $this->stage(array_slice($messages, count($this->stored)));
    }

    /**
     * The thread's request options, as given at creation and changed by update().
     *
     * @internal
     */
    public function requestOptions(): RequestOptions
    {
        return $this->requestOptions;
    }

    /**
     * Throws what send() with no arguments would throw before it sends a request.
     *
     * @internal
     *
     * @throws \LogicException
     */
    public function assertNextTurnCanBeSent(): void
    {
        $this->assertIdle();
        $this->createOnly($this->fields);
    }

    /**
     * Whether the next turn is sent on a thread.
     *
     * @internal
     */
    public function isThreading(): bool
    {
        return Unanchored::UNTHREADED !== $this->next;
    }

    /**
     * Sends every later turn without a thread.
     *
     * @internal
     */
    public function stopThreading(): void
    {
        $this->next = Unanchored::UNTHREADED;
    }

    /**
     * Whether the two messages are the same in a request.
     *
     * @internal
     *
     * @param Message $message
     * @param Message $other
     */
    public static function sameMessage(array|BaseModel $message, array|BaseModel $other): bool
    {
        return self::json($message) === self::json($other);
    }

    /**
     * Container-bound server tools reject a request that leaves out the container the request
     * before it ran in, so its id is sent on later requests unless the caller named one.
     *
     * @internal
     *
     * @param array<string, mixed> $fields
     *
     * @return array<string, mixed>
     */
    public static function withContainerOf(array $fields, BetaMessage $reply): array
    {
        $id = ($reply->container ?? null)?->id;
        if (null === $id) {
            return $fields;
        }

        $container = $fields['container'] ?? null;
        if (null === $container) {
            $fields['container'] = $id;
        } elseif ($container instanceof BetaContainerParams && null === $container->id) {
            $fields['container'] = $container->withID($id);
        } elseif (is_array($container) && !isset($container['id'])) {
            $fields['container'] = ['id' => $id] + $container;
        }

        return $fields;
    }

    private function startNewThread(): void
    {
        if ($this->isThreading()) {
            $this->next = Unanchored::CREATE;
        }
    }

    /**
     * @param array<string, mixed> $params
     */
    private static function rejectThreadParam(array $params): void
    {
        if (null !== ($params['thread'] ?? null)) {
            throw new \InvalidArgumentException('`thread` cannot be set on a message thread: the thread sets it for each request itself.');
        }
    }

    private function assertIdle(): void
    {
        if (null !== $this->deferred) {
            throw new \LogicException('Another turn is in progress on this message thread. Wait for it to end, or close() its stream.');
        }
    }

    /**
     * @param array<string, mixed>|list<Message>|BaseModel|null $messages
     * @param array<string, mixed> $params
     */
    private function startTurn(array|BaseModel|null $messages, array $params): void
    {
        $this->assertIdle();
        self::rejectThreadParam($params);

        $appended = count($this->staged);
        $this->stage(self::messageList($messages));
        $this->givenToTurn = count($this->staged) - $appended;
        $this->retryPartialTurn();
        $this->deferred = [];
    }

    private function endTurn(): void
    {
        // A reply that is recorded, in whole or in part, empties `$staged`, so this takes messages back only from a turn that left none.
        array_splice($this->staged, count($this->staged) - $this->givenToTurn);

        $deferred = $this->deferred ?? [];
        $this->deferred = null;
        $this->stage($deferred);
    }

    /**
     * When nothing is staged and the history ends with a turn whose stream ended early, stages
     * the messages of that turn again, without the part of the reply that arrived.
     */
    private function retryPartialTurn(): void
    {
        $tail = $this->stored[count($this->stored) - 1] ?? null;
        if ([] !== $this->staged || null === $tail || $tail instanceof BetaMessage) {
            return;
        }

        if ($tail instanceof PartialReply) {
            array_pop($this->stored);
        }
        $this->staged = array_splice($this->stored, $this->answered());
    }

    /**
     * How many of the stored messages were answered: those up to and including the last reply,
     * whole or partial. A stream that ended before any content leaves messages after it.
     */
    private function answered(): int
    {
        $answered = count($this->stored);
        while ($answered > 0 && null === self::replyOf($this->stored[$answered - 1])) {
            --$answered;
        }

        return $answered;
    }

    /**
     * Sends the request of the turn in progress, again for as long as the thread recovers from
     * the API's rejection.
     *
     * @template T
     *
     * @param \Closure(array<string, mixed>): T $send takes the arguments of create()
     * @param array<string, mixed> $params
     * @param RequestOpts|null $requestOptions
     *
     * @return array{T, CreateOnly} the response, and the `system` and `tools` of the thread that the request was part of
     */
    private function request(\Closure $send, array $params, RequestOptions|array|null $requestOptions): array
    {
        while (true) {
            $arguments = self::overlay($this->fields, $params);
            $createOnly = $this->createOnly($arguments);

            $arguments['messages'] = array_map(self::messageParam(...), $this->staged);
            if (isset($arguments['tools'])) {
                $arguments['tools'] = self::toolDefinitions($arguments['tools']);
            }
            if ($this->next instanceof Anchor) {
                unset($arguments['system'], $arguments['tools']);
                $arguments['thread'] = ['type' => 'continue', 'previousMessageID' => $this->next->previousMessageId];
            } else {
                $arguments['messages'] = [
                    ...array_map(self::sentAgain(...), array_slice($this->stored, 0, $this->answered())),
                    ...array_map(self::messageParam(...), array_slice($this->stored, $this->answered())),
                    ...$arguments['messages'],
                ];
            }
            if ($this->isThreading()) {
                $arguments['thread'] ??= ['type' => 'create'];
                $arguments['betas'] = self::withThreadsBeta($arguments['betas'] ?? null);
            }
            $options = RequestOptions::parse($this->requestOptions, $requestOptions);
            $headers = $options->extraHeaders ?? [];
            $helpers = StainlessHelperHeader::mergedValue($headers, StainlessHelperHeader::MESSAGE_THREAD);
            $arguments['requestOptions'] = $options->withExtraHeaders([...$headers, StainlessHelperHeader::HEADER => $helpers]);

            try {
                return [$send($arguments), $createOnly];
            } catch (APIStatusException $e) {
                if (!$this->recoversFrom($e)) {
                    throw $e;
                }
            }
        }
    }

    /**
     * Whether the request should be sent again because the API rejected its thread in a way that
     * the thread has now adjusted for.
     */
    private function recoversFrom(APIStatusException $error): bool
    {
        $code = $error->body;
        foreach (['error', 'details', 'error_code'] as $key) {
            $code = is_array($code) ? ($code[$key] ?? null) : null;
        }

        if ($this->next instanceof Anchor && in_array($code, self::REPLAY_ERROR_CODES, true)) {
            $this->next = match (true) {
                'thread_not_found' !== $code => Unanchored::CREATE,
                // The API kept neither the thread nor the one that replaced it, so it may be unable to store this conversation.
                $this->next->createdAfterNotFound && UnsupportedRequestBehavior::CONTINUE_UNTHREADED === $this->unsupportedRequestBehavior => Unanchored::UNTHREADED,
                default => Unanchored::CREATE_AFTER_NOT_FOUND,
            };

            return true;
        }

        if (
            Unanchored::UNTHREADED !== $this->next
            && 'thread_unsupported_request' === $code
            && UnsupportedRequestBehavior::CONTINUE_UNTHREADED === $this->unsupportedRequestBehavior
        ) {
            $this->next = Unanchored::UNTHREADED;

            return true;
        }

        return false;
    }

    /**
     * @param array<string, mixed> $fields
     *
     * @return CreateOnly the fields that the API takes from the thread on a `continue`, and each as JSON, so that a later edit of a model object in them shows as a change
     *
     * @throws \LogicException if a request with `$fields` would continue the thread with another `system` or `tools`
     */
    private function createOnly(array $fields): array
    {
        $createOnly = ['system' => $fields['system'] ?? null, 'tools' => $fields['tools'] ?? null];
        $json = array_map(self::json(...), $createOnly);

        // A `continue` leaves these fields out, so the API could not tell that the turn changes one.
        $changed = array_keys(array_diff_assoc($json, $this->next instanceof Anchor ? $this->next->createdWith : $json));
        if ([] !== $changed) {
            throw new \LogicException(
                'Cannot change `'.implode('` and `', $changed).'` on a thread: the server keeps the `system` and `tools` the thread was created with. '
                .'To change them, start a new thread from `$thread->params()`.'
                .(in_array('tools', $changed, true) ? ' To add or remove tools on this thread, send `tool_addition` or `tool_removal` blocks in a `system` message.' : '')
            );
        }

        return ['fields' => $createOnly, 'json' => $json];
    }

    /**
     * Forwards the events of a streamed turn, and records how the turn ended.
     *
     * @param BaseStream<StreamEvent> $events
     * @param CreateOnly $createdWith
     *
     * @return \Generator<int, StreamEvent>
     */
    private function forward(BaseStream $events, array $createdWith): \Generator
    {
        $accumulator = MessageAccumulator::forBetaMessages();
        // `null` until the reply starts.
        $finishedBlocks = null;

        try {
            foreach ($events as $event) {
                $accumulator->accumulate($event);
                if ('message_start' === $event->type) {
                    $finishedBlocks = 0;
                } elseif ('content_block_stop' === $event->type) {
                    ++$finishedBlocks;
                } elseif ('message_stop' === $event->type) {
                    $this->recordReply(self::snapshot($accumulator), $createdWith);
                    $this->endTurn();
                }

                yield $event;
            }
        } finally {
            if (!$accumulator->isComplete()) {
                if (null !== $finishedBlocks) {
                    $this->recordPartialReply(self::snapshot($accumulator), $finishedBlocks);
                }
                $this->endTurn();
            }
            $events->close();
        }
    }

    private static function snapshot(MessageAccumulator $accumulator): BetaMessage
    {
        $snapshot = $accumulator->message();
        assert($snapshot instanceof BetaMessage);

        return $snapshot;
    }

    /**
     * A refused turn is not recorded. The API can hold it all the same, and a `continue` cannot
     * remove it, so the next turn starts a new thread.
     *
     * @param CreateOnly $createdWith
     */
    private function recordReply(BetaMessage $reply, array $createdWith): void
    {
        if (BetaStopReason::REFUSAL->value === $reply->stopReason) {
            $this->startNewThread();

            return;
        }

        $this->stored = [...$this->stored, ...$this->staged, $reply];
        $this->staged = [];
        if ($this->isThreading()) {
            if (!$this->next instanceof Anchor) {
                $this->fields = self::overlay($this->fields, $createdWith['fields']);
            }
            $this->next = self::isFromAFallbackModel($reply)
                ? Unanchored::CREATE
                : new Anchor($reply->id, $createdWith['json'], createdAfterNotFound: Unanchored::CREATE_AFTER_NOT_FOUND === $this->next);
        }
        $this->fields = self::withContainerOf($this->fields, $reply);
    }

    /**
     * A thread keeps one model, so the API does not store a turn that a model of `fallbacks` wrote.
     */
    private static function isFromAFallbackModel(BetaMessage $reply): bool
    {
        foreach ($reply->usage->iterations ?? [] as $iteration) {
            // By type too: an entry type this SDK version does not model is parsed into another entry's class.
            if ($iteration instanceof BetaFallbackMessageIterationUsage && 'fallback_message' === $iteration['type']) {
                return true;
            }
        }

        return false;
    }

    /**
     * The API holds either the whole reply or none of it, so the next turn starts a new thread. An
     * unfinished block other than text is dropped, because its input or signature is incomplete.
     */
    private function recordPartialReply(BetaMessage $snapshot, int $finishedBlocks): void
    {
        $this->startNewThread();
        if (BetaStopReason::REFUSAL->value === $snapshot->stopReason) {
            return;
        }

        $content = array_slice($snapshot->content, 0, $finishedBlocks);
        $unfinished = $snapshot->content[$finishedBlocks] ?? null;
        if ($unfinished instanceof BetaTextBlock && '' !== $unfinished->text) {
            $content[] = $unfinished;
        }

        $this->stored = [...$this->stored, ...$this->staged];
        $this->staged = [];
        if ([] !== $content) {
            $this->stored[] = new PartialReply($snapshot->withContent($content));
        }
    }

    /**
     * @param list<Message> $messages
     */
    private function stage(array $messages): void
    {
        foreach ($messages as $message) {
            if (!$this->repeatsLastReply($message)) {
                $this->staged[] = self::messageParam($message);
            }
        }
    }

    /**
     * @param Message $message
     */
    private function repeatsLastReply(array|BaseModel $message): bool
    {
        $reply = self::replyOf($this->staged[count($this->staged) - 1] ?? $this->stored[count($this->stored) - 1] ?? null);
        if (null === $reply) {
            return false;
        }

        return $message instanceof BetaMessage ? $message->id === $reply->id : self::sameMessage($message, self::messageParam($reply));
    }

    private static function replyOf(mixed $recorded): ?BetaMessage
    {
        if ($recorded instanceof PartialReply) {
            return $recorded->message;
        }

        return $recorded instanceof BetaMessage ? $recorded : null;
    }

    /**
     * @param Recorded $recorded
     *
     * @return Message
     */
    private static function messageParam(array|BaseModel|PartialReply $recorded): array|BaseModel
    {
        if ($recorded instanceof PartialReply) {
            $recorded = $recorded->message;
        }

        return $recorded instanceof BetaMessage ? ['role' => 'assistant', 'content' => $recorded->content] : $recorded;
    }

    /**
     * The cache breakpoints of earlier turns add up over a conversation, and a request that sends
     * them all again can hold more than the API allows.
     *
     * @param Recorded $recorded
     *
     * @return Message the answered message as a request that sends the history again carries it, without its cache breakpoints
     */
    private static function sentAgain(array|BaseModel|PartialReply $recorded): array|BaseModel
    {
        // A reply holds none.
        return $recorded instanceof PartialReply || $recorded instanceof BetaMessage ? self::messageParam($recorded) : self::withoutCacheControl($recorded);
    }

    /**
     * @template K of array-key
     *
     * @param array<K, mixed>|BaseModel $value a message, a content block or a tool
     *
     * @return array<K, mixed>|BaseModel a copy of `$value` without its `cache_control` and that of the content blocks and tools in it
     */
    private static function withoutCacheControl(array|BaseModel $value): array|BaseModel
    {
        $copy = is_array($value) ? $value : clone $value;
        unset($copy['cacheControl'], $copy['cache_control']);

        // Only these keys hold content blocks and tools. Any other value can be free-form JSON, where the key is no breakpoint.
        foreach (['content', 'source', 'tool', 'definition', 'toolReferences', 'tool_references'] as $key) {
            $nested = $copy[$key] ?? null;
            if (is_array($nested) && array_is_list($nested)) {
                $copy[$key] = array_map(static fn (mixed $item) => is_array($item) || $item instanceof BaseModel ? self::withoutCacheControl($item) : $item, $nested);
            } elseif (is_array($nested) || $nested instanceof BaseModel) {
                $copy[$key] = self::withoutCacheControl($nested);
            }
        }

        return $copy;
    }

    /**
     * @param array<string, mixed>|list<Message>|BaseModel|null $messages one message, or a list of messages
     *
     * @return list<Message>
     */
    private static function messageList(array|BaseModel|null $messages): array
    {
        if (null === $messages) {
            return [];
        }

        // @phpstan-ignore return.type
        return is_array($messages) && array_is_list($messages) ? $messages : [$messages];
    }

    private static function json(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /**
     * @return list<mixed> `tools` as the API receives them: a `BetaRunnableTool` is sent as its definition
     */
    private static function toolDefinitions(mixed $tools): array
    {
        return array_map(
            static fn (mixed $tool) => $tool instanceof BetaRunnableTool ? $tool->definition : $tool,
            is_array($tools) ? array_values($tools) : [],
        );
    }

    /**
     * @return list<mixed>
     */
    private static function withThreadsBeta(mixed $betas): array
    {
        $betas = is_array($betas) ? array_values($betas) : [];
        $threadsBeta = AnthropicBeta::MESSAGE_THREADS_2026_08_12;

        return in_array($threadsBeta, $betas, true) || in_array($threadsBeta->value, $betas, true) ? $betas : [...$betas, $threadsBeta->value];
    }

    /**
     * @param array<string, mixed> $fields
     * @param array<string, mixed> $overrides a field set to `null` is removed
     *
     * @return array<string, mixed>
     */
    private static function overlay(array $fields, array $overrides): array
    {
        return array_filter([...$fields, ...$overrides], static fn (mixed $value) => null !== $value);
    }
}
