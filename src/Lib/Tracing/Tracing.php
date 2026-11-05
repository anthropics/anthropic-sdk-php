<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

use Anthropic\Aws;
use Anthropic\Bedrock;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Util;
use Anthropic\Foundry;
use Anthropic\GoogleCloud;
use Anthropic\Lib\Streaming\MessageAccumulator;
use Anthropic\Messages\Message;
use Anthropic\RequestOptions;
use Anthropic\Vertex;
use OpenTelemetry\API\Behavior\LogsMessagesTrait;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\NoopTracer;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Psr\Http\Message\RequestInterface;

/**
 * The tracing of `Anthropic\Core\Tracing`, specialized for this API: the call span gets its `gen_ai.*` and
 * `anthropic.*` attributes, and the Messages tool runner its `INTERNAL` spans. `BaseClient` and `RawResponse`
 * import this class in place of the generated one.
 *
 * @internal
 *
 * @phpstan-import-type ApiCallResult from \Anthropic\Core\Tracing
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 */
final class Tracing extends \Anthropic\Core\Tracing
{
    use LogsMessagesTrait;

    /** The headers of the W3C trace context and baggage, which no signature covers whatever propagator is registered. */
    private const TRACE_CONTEXT_HEADERS = ['traceparent', 'tracestate', 'baggage'];

    /**
     * The paths of the fields of a Message that are final only from `message_delta` on: `message_start` has a
     * placeholder for each. A streamed Message sets no attribute from them until `message_delta` was read.
     *
     * @var list<list<string>>
     */
    private const FINAL_FROM_MESSAGE_DELTA = [
        ['stop_reason'],
        ['usage', 'output_tokens'],
        ['usage', 'output_tokens_details', 'thinking_tokens'],
    ];

    /**
     * Ends the call span of an API call as the generated `endApiCallSpan` does, after setting the span's `gen_ai.*`
     * and `anthropic.*` attributes that come from the call's result. A streamed Message is recorded as the
     * application reads it.
     *
     * @param ApiCallResult $result
     *
     * @return mixed what to hand to the application: `$result['data']`, or the `TracedStream` that reads it
     */
    public static function endApiCallSpan(BaseClient $client, SpanInterface $span, array $result): mixed
    {
        if ($span->isRecording()) {
            try {
                $result = self::recordApiCall($client, $span, $result);
            } catch (\Throwable $problem) {
                // A failure to record telemetry must not fail the API call.
                self::logDebug('could not record the API call on its span', ['exception' => $problem]);
            }
        }

        return parent::endApiCallSpan($client, $span, $result);
    }

    /**
     * Starts the call span of an API call as the generated `startApiCallSpan` does. A call to a Session thread's path
     * that names no conversation is in the conversation of that thread: its span starts with the thread's ID as
     * `gen_ai.conversation.id` too. A conversation ID in `$attributes`, which the application set, stays as it is.
     *
     * @param array<non-empty-string,mixed> $attributes
     */
    public static function startApiCallSpan(TracerInterface $tracer, ?string $name, array $attributes = [], bool $propagates = true): ?SpanInterface
    {
        $thread = $attributes[TraceAttributes::ANTHROPIC_SESSION_THREAD_ID] ?? null;
        if (is_string($thread) && !isset($attributes[TraceAttributes::GEN_AI_CONVERSATION_ID])) {
            $attributes[TraceAttributes::GEN_AI_CONVERSATION_ID] = $thread;
        }

        return parent::startApiCallSpan($tracer, $name, $attributes, $propagates);
    }

    /**
     * The tracer for one API call of `$client`, whose spans are enabled, from the tracer provider that the generated
     * `tracer` takes it from. A client of another platform has an instrumentation scope of its own: the SDK's, then
     * the platform's name as the client's namespace spells it, in lower case. Its version is the SDK's, which the
     * client ships with.
     */
    public static function clientTracer(BaseClient $client): TracerInterface
    {
        $platform = match (true) {
            $client instanceof Aws\Client => 'aws',
            $client instanceof Bedrock\Client, $client instanceof Bedrock\MantleClient => 'bedrock',
            $client instanceof Foundry\Client, $client instanceof Foundry\ServiceClient => 'foundry',
            $client instanceof GoogleCloud\Client => 'googlecloud',
            $client instanceof Vertex\Client => 'vertex',
            default => null,
        };
        $option = $client->openTelemetry;
        if (null === $platform) {
            return self::tracer($option);
        }
        $provider = is_array($option) ? ($option['tracerProvider'] ?? null) : null;

        return ($provider instanceof TracerProviderInterface ? $provider : Globals::tracerProvider())->getTracer(self::INSTRUMENTATION_SCOPE.'.'.$platform, \Anthropic\VERSION);
    }

    /**
     * Starts the tool runner span, the `anthropic.messages.tool_runner` span of one loop of the Messages tool
     * runner, as a child of the current span. `$setsJsonOutputFormat` says whether the runner's request parameters
     * set the output format to JSON. The runner sets the span's status and ends it. Null when the client's spans are
     * disabled.
     */
    public static function startToolRunnerSpan(BaseClient $client, string $model, ?string $conversationId, bool $setsJsonOutputFormat): ?SpanInterface
    {
        // The span starts with everything the runner knows of its loop, so that a sampler sees it.
        $attributes = [
            TraceAttributes::GEN_AI_OPERATION_NAME => TraceAttributeValues::GEN_AI_OPERATION_NAME_VALUE_INVOKE_AGENT,
            TraceAttributes::GEN_AI_PROVIDER_NAME => self::providerName($client),
        ];
        if ('' !== $model) {
            $attributes[TraceAttributes::GEN_AI_REQUEST_MODEL] = $model;
        }
        if ($setsJsonOutputFormat) {
            $attributes[TraceAttributes::GEN_AI_OUTPUT_TYPE] = TraceAttributeValues::GEN_AI_OUTPUT_TYPE_VALUE_JSON;
        }
        if (null !== $conversationId && '' !== $conversationId) {
            $attributes[TraceAttributes::GEN_AI_CONVERSATION_ID] = $conversationId;
        }

        try {
            return $client->tracer()?->spanBuilder('anthropic.messages.tool_runner')->setSpanKind(SpanKind::KIND_INTERNAL)->setAttributes($attributes)->startSpan();
        } catch (\Throwable $problem) {
            // A failure to start the span must not fail the tool runner's loop, which runs without it.
            self::logDebug('could not start the tool runner span', ['exception' => $problem]);

            return null;
        }
    }

    /**
     * Starts the span of one client tool run, as a child of the current span, which is the tool runner span while
     * the runner runs the tool. `$spanName` is `anthropic.custom_tool_use` for a tool the application defined and
     * `anthropic.mcp_tool_use` for a tool an MCP helper made. The span's name carries the tool's name after a space,
     * and is `$spanName` alone when the tool has none. {@see self::endToolUseSpan()} ends it. Null when the
     * client's spans are disabled.
     *
     * `$description` is the description in the tool's definition: the application's, or, for a tool an MCP helper
     * made, the MCP server's. An exporter fails on a string that is not UTF-8, and loses every span it exports with
     * it, so such a description is left out, as is an empty one or one that is no string.
     *
     * `$conversationId` is the conversation ID that the application set on the tool runner, or else on the client,
     * as it is when the runner runs the tool. `$toolsetName` is the `toolset_name` of the `tool_use` block that the
     * runner executes, which most blocks do not have.
     *
     * @param 'anthropic.custom_tool_use'|'anthropic.mcp_tool_use' $spanName
     */
    public static function startToolUseSpan(BaseClient $client, string $spanName, string $id, string $name, mixed $description = null, ?string $conversationId = null, mixed $toolsetName = null): ?SpanInterface
    {
        $attributes = [
            TraceAttributes::GEN_AI_OPERATION_NAME => TraceAttributeValues::GEN_AI_OPERATION_NAME_VALUE_EXECUTE_TOOL,
            TraceAttributes::GEN_AI_PROVIDER_NAME => self::providerName($client),
            TraceAttributes::GEN_AI_TOOL_NAME => $name,
            TraceAttributes::GEN_AI_TOOL_CALL_ID => $id,
            TraceAttributes::GEN_AI_TOOL_TYPE => TraceAttributeValues::GEN_AI_TOOL_TYPE_VALUE_FUNCTION,
        ];
        if (is_string($toolsetName) && '' !== $toolsetName) {
            $attributes[TraceAttributes::ANTHROPIC_TOOLSET_NAME] = $toolsetName;
        }
        if (is_string($description) && '' !== $description && 1 === preg_match('//u', $description)) {
            $attributes[TraceAttributes::GEN_AI_TOOL_DESCRIPTION] = $description;
        }
        if (null !== $conversationId && '' !== $conversationId) {
            $attributes[TraceAttributes::GEN_AI_CONVERSATION_ID] = $conversationId;
        }

        try {
            return $client->tracer()
                ?->spanBuilder('' === $name ? $spanName : "{$spanName} {$name}")
                ->setSpanKind(SpanKind::KIND_INTERNAL)
                ->setAttributes($attributes)
                ->startSpan()
            ;
        } catch (\Throwable $problem) {
            // A failure to start the span must not keep the tool from running.
            self::logDebug('could not start the span of the tool run', ['exception' => $problem]);

            return null;
        }
    }

    /**
     * Ends the tool span of a client tool run with `$result`, the `tool_result` block the tool
     * runner made of the run to send back to the model, or null when it made none. An error result, or none, fails
     * the span with `tool_error`. In content mode the span gets the tool's `$input` and the result's content, as a
     * list of content blocks, within the size limit ({@see Content::setToolContentAttributes()}).
     *
     * @param array{type: 'tool_result', tool_use_id: string, content: mixed, is_error?: bool}|null $result
     */
    public static function endToolUseSpan(BaseClient $client, SpanInterface $span, mixed $input, ?array $result): void
    {
        if (self::recordsContent($client)) {
            try {
                Content::setToolContentAttributes($span, $input, null === $result ? null : Content::blocks($result['content']), self::contentLimit($client));
            } catch (\Throwable $problem) {
                // A failure to record telemetry, such as content that JSON cannot hold, must not fail the run.
                self::logDebug('could not record the tool run on its span', ['exception' => $problem]);
            }
        }

        try {
            if (null === $result || true === ($result['is_error'] ?? null)) {
                self::setErrorStatus($span, null, 'tool_error');
            } else {
                $span->setStatus(StatusCode::STATUS_OK);
            }
            $span->end();
        } catch (\Throwable $problem) {
            // A span processor that throws must not fail the run, whose result goes back to the model.
            self::logDebug('could not end the span of the tool run', ['exception' => $problem]);
        }
    }

    /**
     * Starts the call span named `$name` of an SDK method that records its response on it and passes it to
     * {@see BaseClient::request()} with the request options. Null when the client's spans are disabled, or when the span would have no effect.
     * A sampler sees only what a span starts with, so the span starts with everything the method knows of its call:
     * the HTTP method, which is POST for both methods, and `$route`, the attributes of
     * {@see self::apiCallSpanAttributes()}, those that {@see self::spanRequestAttributes()} reads from `$body` and from
     * the request headers, and the output type of `messages.create`.
     *
     * @param 'anthropic.messages.count_tokens'|'anthropic.messages.create' $name
     * @param '/v1/messages'|'/v1/messages/count_tokens' $route the endpoint's path as the API description gives it, on every platform
     * @param array<string, mixed> $body the request's parameters, in the API's shape
     * @param array<string, string> $headerParams the parameters of `$body` that the method sends as headers, each with its header
     */
    public static function startCallSpan(BaseClient $client, string $name, string $route, array $body, RequestOptions $options, array $headerParams = []): ?ApiCallSpan
    {
        $tracer = $client->tracer();
        if (null === $tracer) {
            return null;
        }
        // No tracer provider is registered: the span records nothing, so what it would start with is not read. It
        // can still carry the trace context of a span above it.
        if ($tracer instanceof NoopTracer) {
            $span = self::startApiCallSpan($tracer, $name, propagates: $client->propagates());

            return null === $span ? null : new ApiCallSpan($span, $name);
        }
        $attributes = [
            ...self::requestAttributes('POST', $route),
            // The conversation may come from the client's own request options, which `$options` do not have yet.
            ...self::apiCallSpanAttributes($client, $client->mergedOptions($options)),
        ];

        $headers = [];

        try {
            // The headers as the client builds them for the attempts: its own, then the call's.
            $headers = $client->mergedHeaders(Util::array_transform_keys(array_intersect_key($body, $headerParams), $headerParams), $options);
            if ('anthropic.messages.create' === $name && self::setsJsonOutputFormat($body)) {
                $attributes[TraceAttributes::GEN_AI_OUTPUT_TYPE] = TraceAttributeValues::GEN_AI_OUTPUT_TYPE_VALUE_JSON;
            }
        } catch (\Throwable $problem) {
            // A failure to record telemetry must not fail the API call.
            self::logDebug('could not record the request on its span', ['exception' => $problem]);
        }
        $attributes += self::spanRequestAttributes($name, $body, $headers, true === ($body['stream'] ?? null));
        // An empty string or an empty list says nothing. `startApiCallSpan` leaves out what no attribute can hold.
        $span = self::startApiCallSpan($tracer, $name, array_filter($attributes, static fn (mixed $value): bool => '' !== $value && [] !== $value), $client->propagates());

        return null === $span ? null : new ApiCallSpan($span, $name);
    }

    /**
     * Sets on `$span`, the call span that a `messages.create` method started, the system prompt and messages of a
     * streamed request, in content mode. A request that is not streamed gets them when the call ends, with or without
     * the response's content.
     *
     * @param array<string, mixed> $body the request's parameters, in the API's shape
     */
    public static function recordMessagesCreateRequest(BaseClient $client, ?ApiCallSpan $callSpan, array $body): void
    {
        $span = $callSpan?->span;
        if (null === $span || !$span->isRecording()) {
            return;
        }

        try {
            // A call that is not streamed gets its content once, when it ends. A stream gets the request's now, so
            // that one cut short keeps it.
            if (true === ($body['stream'] ?? null) && self::recordsContent($client)) {
                Content::setMessageContent($span, $body, null, self::contentLimit($client));
            }
        } catch (\Throwable $problem) {
            // A failure to record telemetry must not fail the API call.
            self::logDebug('could not record the request on its span', ['exception' => $problem]);
        }
    }

    /**
     * Sets on the call span that a `messages.create` method started what the SDK works out from `$message`, the parsed
     * response to the request `$body`: the token sums and, in content mode, the response's content.
     * {@see self::endApiCallSpan()} sets the attributes that are fields of the response. The content is written together
     * with the request's, so that the size limit counts both. Returns `$message`, and records nothing of a body that did
     * not parse to a Message.
     *
     * @template TParsed
     *
     * @param array<string, mixed> $body the request's parameters, in the API's shape
     * @param TParsed $message
     * @param mixed $decoded the decoded response body that `$message` was built from
     *
     * @return TParsed
     */
    public static function recordMessagesCreateResponse(BaseClient $client, ?ApiCallSpan $callSpan, array $body, mixed $message, mixed $decoded): mixed
    {
        $span = $callSpan?->span;
        if (null === $span || !$span->isRecording() || !($message instanceof Message || $message instanceof BetaMessage) || !is_array($decoded)) {
            return $message;
        }

        try {
            // The sums come from the decoded body: serializing the model back to it costs more than everything else
            // the span records.
            self::setUsageSums($span, $decoded['usage'] ?? null, true);
            if (self::recordsContent($client)) {
                Content::setMessageContent($span, $body, self::messageContentBlocks($decoded), self::contentLimit($client));
            }
        } catch (\Throwable $problem) {
            // A failure to record telemetry must not fail the API call.
            self::logDebug('could not record the response on its span', ['exception' => $problem]);
        }

        return $message;
    }

    /**
     * Whether the parameters of a Messages request set the output format to JSON, in `output_config.format` or the
     * deprecated `output_format`: `json_schema` is the one format that is JSON.
     *
     * @param array<string, mixed> $body the request's parameters, in the API's shape
     */
    public static function setsJsonOutputFormat(array $body): bool
    {
        $format = $body['output_format'] ?? self::field($body['output_config'] ?? null, 'format');

        return 'json_schema' === self::field($format, 'type');
    }

    /**
     * Signs `$request` with `$sign` so that the signature does not cover the trace context headers, and returns the
     * signed request with those headers back on it. An HTTP instrumentation below the SDK may replace them with the
     * context of its own span, and a signature that covered them would then no longer match the request.
     *
     * The headers are `traceparent`, `tracestate` and `baggage`, and the fields of the propagator that is registered
     * when the request is signed.
     *
     * @param callable(RequestInterface): RequestInterface $sign
     */
    public static function signWithoutTraceContext(RequestInterface $request, callable $sign): RequestInterface
    {
        $held = [];

        try {
            $fields = Globals::propagator()->fields();
        } catch (\Throwable $problem) {
            // A propagator that throws must not fail the API call.
            self::logDebug('could not read the fields of the propagator', ['exception' => $problem]);
            $fields = [];
        }
        foreach ([...self::TRACE_CONTEXT_HEADERS, ...$fields] as $name) {
            $name = strtolower($name);
            if (!isset($held[$name]) && $request->hasHeader($name)) {
                $held[$name] = $request->getHeader($name);
                $request = $request->withoutHeader($name);
            }
        }
        $request = $sign($request);
        foreach ($held as $name => $values) {
            $request = $request->withHeader($name, $values);
        }

        return $request;
    }

    /**
     * The `conversationId` of the `openTelemetry` request option, when it is a string.
     *
     * @param RequestOptions|array<mixed>|null $options
     */
    public static function conversationId(RequestOptions|array|null $options): ?string
    {
        $option = $options instanceof RequestOptions ? ($options->openTelemetry ?? null) : ($options['openTelemetry'] ?? null);
        $id = is_array($option) ? ($option['conversationId'] ?? null) : null;

        return is_string($id) ? $id : null;
    }

    /**
     * Whether a client's spans carry content attributes, from the `traces.contentMode` of its `openTelemetry` option.
     * The environment variable `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` applies only to a client that is given
     * no option. A client asks once, when it is built, so the variable is read then and a later change to it does not
     * reach the client.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function contentEnabled(array|false|null $option): bool
    {
        if (!is_null($option)) {
            return parent::contentEnabled($option);
        }

        return 'content' === strtolower(Util::getenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE') ?? '');
    }

    /**
     * The most bytes that the content attributes of one span hold, from the `traces.maxContentBytes` of a client's
     * `openTelemetry` option, or null for the SDK's own bound, {@see Content::LIMIT}. The environment variable
     * `ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES` applies only to a client that is given no option. A value
     * of the variable that is no whole number of at least 1 is ignored, as an unknown content mode is. A client asks
     * once, when it is built.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function maxContentBytes(array|false|null $option): ?int
    {
        if (!is_null($option)) {
            return parent::maxContentBytes($option);
        }
        // Digits only, so that a number with leading zeros is the number it reads as. One too large for an integer is the largest integer.
        $fromEnvironment = trim(Util::getenv('ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES') ?? '');

        return ctype_digit($fromEnvironment) && (int) $fromEnvironment >= 1 ? (int) $fromEnvironment : null;
    }

    /**
     * The most bytes that the content attributes of one span of `$client` hold, as the client resolved it when it
     * was built.
     */
    public static function contentLimit(BaseClient $client): int
    {
        return $client->maxContentBytes() ?? Content::LIMIT;
    }

    /**
     * The attributes that every call span of `$client` starts with: the provider, the conversation when `$options`
     * name one, and the host and port of the client's base URL, as the generated `callSpanAttributes` gives them.
     * `$options` are the call's merged with the client's own, as {@see BaseClient::mergedOptions()} gives them.
     *
     * @return array<non-empty-string, string|int>
     */
    public static function apiCallSpanAttributes(BaseClient $client, RequestOptions $options): array
    {
        return array_filter(
            [
                TraceAttributes::GEN_AI_PROVIDER_NAME => self::providerName($client),
                TraceAttributes::GEN_AI_CONVERSATION_ID => self::conversationId($options),
                ...parent::callSpanAttributes($client->getBaseUrl()),
            ],
            static fn (string|int|null $value): bool => null !== $value && '' !== $value,
        );
    }

    /**
     * The `gen_ai.provider.name` of the spans of `$client`: the platform that serves its requests.
     */
    private static function providerName(BaseClient $client): string
    {
        return match (true) {
            $client instanceof Bedrock\Client, $client instanceof Bedrock\MantleClient => 'aws.bedrock',
            $client instanceof Vertex\Client => 'gcp.vertex_ai',
            default => 'anthropic',
        };
    }

    /**
     * Returns `$result`, whose `events`, when `data` is a streamed Message, is a generator that reads its events and
     * records the Message as it is read, whose `isComplete` then says whether the stream was read to its end and
     * `message_stop` was among its events, and whose `beforeEnd` records the Message of a stream that ends before
     * `message_stop`.
     *
     * @param ApiCallResult $result
     *
     * @return ApiCallResult
     */
    private static function recordApiCall(BaseClient $client, SpanInterface $span, array $result): array
    {
        $request = $result['request'];
        $name = $result['options']->apiCall()?->name;
        $data = $result['data'] ?? null;

        // What a method knows of its own request and response it sets itself. A streamed Message is recorded as the
        // application reads it: only the call's result has it.
        if ('anthropic.messages.create' === $name) {
            if ($data instanceof BaseStream) {
                $body = self::wire($request['body']);
                $body = is_array($body) ? $body : [];
                $recorded = new StreamedMessage;
                // The span has the request's content since the method started it, and gets it again with the
                // response's once `message_stop` is read, so that a stream cut short keeps the request's.
                $limit = self::contentLimit($client);
                $result['events'] = self::recordMessagesCreateStreamEvents($span, $data->getIterator(), $recorded, $result['startTime'], $body, self::recordsContent($client), $limit);
                // The call is complete once the API has closed the stream after `message_stop`. A stream that the
                // application closes first, even after `message_stop`, is a cancellation: its span keeps no status.
                $result['isComplete'] = static fn (): bool => $recorded->stopped && $recorded->ended;
                // A stream that ends before `message_stop`, however it ends, gets the Message as far as it was read.
                $result['beforeEnd'] = static function () use ($span, $recorded, $body, $limit): void {
                    self::recordPartialMessageContent($span, $recorded, $body, $limit);
                };
            } elseif (!($data instanceof Message || $data instanceof BetaMessage) && self::recordsContent($client)) {
                // The call failed, or its response was never parsed: the method did not write the content with
                // the response's, so the request's is written alone.
                $body = self::wire($request['body']);
                Content::setMessageContent($span, is_array($body) ? $body : [], null, self::contentLimit($client));
            }
        }

        return $result;
    }

    /**
     * A generator that reads through `$events`, the events of a streamed Message, to record each one as it is read and
     * keep the span's response attributes up to date with `$recorded`, which it marks as ended once the stream has been
     * read to its end. The time to the first chunk is set when the first `content_block_delta` is read.
     *
     * Without `$content`, only the events that `$recorded` reads are serialized. With it, every event also goes to
     * the SDK's own {@see MessageAccumulator}, which `$recorded` keeps: its Message gives the span its output content
     * at `message_stop`, or when the stream ends before it. An event the accumulator rejects leaves the span without
     * output content. `$limit` is the most bytes that the span's content attributes hold.
     *
     * @template TKey
     * @template TEvent
     *
     * @param \Iterator<TKey, TEvent> $events
     * @param array<mixed> $body
     *
     * @return \Generator<TKey, TEvent>
     */
    private static function recordMessagesCreateStreamEvents(SpanInterface $span, \Iterator $events, StreamedMessage $recorded, int|float $startTime, array $body, bool $content, int $limit): \Generator
    {
        $first = true;
        $timed = false;
        foreach ($events as $key => $event) {
            try {
                if ($first) {
                    if ($content) {
                        $recorded->accumulator = $event instanceof BetaRawMessageStartEvent ? MessageAccumulator::forBetaMessages() : MessageAccumulator::forMessages();
                    }
                    $first = false;
                }
                $type = self::eventType($event);
                // The first chunk is the first `content_block_delta`, whatever its delta: a response without one has
                // no such time.
                if (!$timed && 'content_block_delta' === $type) {
                    $span->setAttribute(TraceAttributes::GEN_AI_RESPONSE_TIME_TO_FIRST_CHUNK, (hrtime(true) - $startTime) / 1e9);
                    $timed = true;
                }
                $changesMessage = in_array($type, StreamedMessage::EVENT_TYPES, true);
                if ($changesMessage || null !== $recorded->accumulator) {
                    $wire = self::wire($event);
                    if (null !== $recorded->accumulator) {
                        try {
                            $recorded->accumulator->accumulate($wire);
                        } catch (\Throwable $problem) {
                            // The accumulator rejects events that are out of order. No output content is better than a wrong one.
                            $recorded->accumulator = null;
                            self::logDebug('could not accumulate the streamed Message for its span', ['exception' => $problem]);
                        }
                    }
                    if ($changesMessage && $recorded->add($wire) && null !== $recorded->message) {
                        self::setStreamedMessageAttributes($span, $recorded->message, $recorded->usage, $recorded->finalized || $recorded->stopped);
                        if ($recorded->stopped && null !== $recorded->accumulator) {
                            Content::setMessageContent($span, $body, self::messageContentBlocks($recorded->accumulator->message()), $limit);
                        }
                    }
                }
            } catch (\Throwable $problem) {
                // Reading the stream must not fail on the telemetry's account.
                self::logDebug('could not record the streamed Message on its span', ['exception' => $problem]);
            }

            yield $key => $event;
        }
        // Only a stream read to the end of the response body gets here: closing or dropping it leaves this generator
        // at its `yield`.
        $recorded->ended = true;
    }

    /**
     * Sets on `$span`, the call span of a streamed Message that is about to end, the content of the Message that the
     * SDK's own accumulator has built from the events read, when the stream ended before `message_stop`: the API
     * ended it, reading it failed, or the application closed or dropped it. A tool use whose input was still being
     * streamed has the input of the accumulator's Message: an empty object until the input's JSON is whole. Sets
     * nothing when no `message_start` was read or nothing accumulates the stream: outside content mode, or after
     * the accumulator rejected an event. `$limit` is the most bytes that the span's content attributes hold.
     *
     * @param array<mixed> $body
     */
    private static function recordPartialMessageContent(SpanInterface $span, StreamedMessage $recorded, array $body, int $limit): void
    {
        if ($recorded->stopped || null === $recorded->message || null === $recorded->accumulator) {
            return;
        }

        try {
            Content::setMessageContent($span, $body, self::messageContentBlocks($recorded->accumulator->message()), $limit);
        } catch (\Throwable $problem) {
            // A failure to record telemetry must not fail the application's reading, closing or dropping of the stream.
            self::logDebug('could not record the partial streamed Message on its span', ['exception' => $problem]);
        }
    }

    /**
     * The `type` of a stream event, a model or an array, read without serializing the event.
     */
    private static function eventType(mixed $event): ?string
    {
        $type = is_array($event) ? ($event['type'] ?? null) : (is_object($event) ? ($event->type ?? null) : null);

        return is_string($type) ? $type : null;
    }

    /**
     * The content blocks of `$message`, a Message as a model or in the API's shape, for the output content.
     *
     * @return list<mixed>|null
     */
    private static function messageContentBlocks(mixed $message): ?array
    {
        $output = self::wire(self::field($message, 'content'));

        return is_array($output) ? array_values($output) : null;
    }

    /**
     * Sets the response attributes of a streamed Message as far as it has been read. The fields of
     * {@see self::FINAL_FROM_MESSAGE_DELTA} are placeholders in `message_start`, so their attributes are left out unless
     * `$complete` is true: once `message_delta` has brought them, so that a stream that ends after it keeps them, and one
     * that ends before it has none.
     *
     * @param array<mixed> $message
     * @param array<mixed> $usage
     */
    private static function setStreamedMessageAttributes(SpanInterface $span, array $message, array $usage, bool $complete): void
    {
        $attributes = self::spanResponseAttributes('anthropic.messages.create', [...$message, 'usage' => $usage]);
        if (!$complete) {
            foreach (self::SPAN_ATTRIBUTES['anthropic.messages.create']['response'] as $attribute => [$path]) {
                if (in_array($path, self::FINAL_FROM_MESSAGE_DELTA, true)) {
                    unset($attributes[$attribute]);
                }
            }
        }
        foreach ($attributes as $attribute => $value) {
            self::set($span, $attribute, $value);
        }
        self::setUsageSums($span, $usage, $complete);
    }

    /**
     * Sets the attributes that are sums over the usage of a Message: the input tokens and, only when `$complete` is
     * true, the compaction tokens, which a streamed Message has once `message_delta` has brought them.
     */
    private static function setUsageSums(SpanInterface $span, mixed $usage, bool $complete): void
    {
        $usage = self::wire($usage);
        if (!is_array($usage)) {
            return;
        }
        if (is_int($usage['input_tokens'] ?? null)) {
            $span->setAttribute(TraceAttributes::GEN_AI_USAGE_INPUT_TOKENS, $usage['input_tokens'] + self::int($usage['cache_read_input_tokens'] ?? null) + self::int($usage['cache_creation_input_tokens'] ?? null));
        }
        if (!$complete) {
            return;
        }
        // The usage above leaves out the compactions, which `iterations` lists among the response's sampling steps.
        $compactionInput = $compactionOutput = null;
        foreach (is_array($usage['iterations'] ?? null) ? $usage['iterations'] : [] as $iteration) {
            if ('compaction' !== self::field($iteration, 'type')) {
                continue;
            }
            $compactionInput = ($compactionInput ?? 0) + self::int(self::field($iteration, 'input_tokens')) + self::int(self::field($iteration, 'cache_read_input_tokens')) + self::int(self::field($iteration, 'cache_creation_input_tokens'));
            $compactionOutput = ($compactionOutput ?? 0) + self::int(self::field($iteration, 'output_tokens'));
        }
        self::set($span, TraceAttributes::ANTHROPIC_USAGE_COMPACTION_INPUT_TOKENS, $compactionInput);
        self::set($span, TraceAttributes::ANTHROPIC_USAGE_COMPACTION_OUTPUT_TOKENS, $compactionOutput);
    }

    /**
     * Sets `$attribute` to `$value` when it is a scalar the attribute can hold.
     *
     * @param non-empty-string $attribute
     */
    private static function set(SpanInterface $span, string $attribute, mixed $value): void
    {
        if ((is_string($value) && '' !== $value) || is_int($value) || is_float($value) || is_bool($value)) {
            $span->setAttribute($attribute, $value);
        }
    }

    /**
     * `$key` of `$value`, an array or an object in the API's shape, or null.
     */
    private static function field(mixed $value, string|int $key): mixed
    {
        $value = self::wire($value);

        return is_array($value) ? ($value[$key] ?? null) : null;
    }

    /**
     * `$value` in the API's shape: a model becomes what it serializes to, and an object its properties.
     */
    private static function wire(mixed $value): mixed
    {
        if ($value instanceof \JsonSerializable) {
            $value = $value->jsonSerialize();
        }

        return is_object($value) ? get_object_vars($value) : $value;
    }

    /**
     * `$value` when it is an integer, and zero otherwise: a usage count that may be absent.
     */
    private static function int(mixed $value): int
    {
        return is_int($value) ? $value : 0;
    }
}
