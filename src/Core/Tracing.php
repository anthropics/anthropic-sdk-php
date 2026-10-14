<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\APITimeoutException;
use Anthropic\Core\Implementation\IteratorExit;
use Anthropic\Core\Implementation\SentRequests;
use Anthropic\Core\Implementation\TracedStream;
use Anthropic\RequestOptions;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\Context;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * OpenTelemetry tracing of the client's API calls.
 *
 * Two terms recur in this file, and wherever else the SDK documents its spans:
 *
 * - An "API call" is one invocation of an SDK method that sends a request to the API. It includes every retry, and reading the stream that the method returns. Its span, a `CLIENT` span named after the method, is the "call span".
 * - An "attempt" is one HTTP request within an API call, with its response when it receives one. An API call that the SDK retries makes several attempts. This SDK emits no span per attempt. The application's HTTP instrumentation, when it has one, emits each "attempt span" as a child of the call span.
 *
 * The client starts the call span before the first attempt (`startApiCallSpan`), sends each attempt with its trace context (`traceAttempt`), records the URL of the first request (`traceRequest`), and ends it with the call's result (`endApiCallSpan`): when the call fails, when the response body has been parsed, or, for a streamed body, when the application has read or closed the stream. An SDK that records more on the call span extends this class and `endApiCallSpan`.
 *
 * @internal
 *
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 *
 * @phpstan-type ApiCallResult = array{
 *   request: NormalizedRequest,
 *   options: RequestOptions,
 *   startTime: int|float,
 *   response?: ResponseInterface,
 *   data?: mixed,
 *   error?: \Throwable,
 *   cancelled?: bool,
 *   events?: \Generator<mixed>,
 *   isComplete?: \Closure(): bool,
 *   beforeEnd?: \Closure(): void,
 * }
 */
class Tracing
{
    public const INSTRUMENTATION_SCOPE = 'com.anthropic.sdk.php';

    // The attributes of the OpenTelemetry semantic conventions that the call spans set, named as the conventions' PHP constants name them. The SDK keeps its own copies so that it does not depend on the conventions package.

    /** The `error.type` attribute: what kind of error an operation failed with. */
    public const ERROR_TYPE = 'error.type';

    /** The `http.request.method` attribute: the HTTP method of the API call's request. */
    public const HTTP_REQUEST_METHOD = 'http.request.method';

    /** The `http.request.resend_count` attribute: how many times the SDK sent the API call's request again, after the first. */
    public const HTTP_REQUEST_RESEND_COUNT = 'http.request.resend_count';

    /** The `http.response.status_code` attribute: the status code of the final response. */
    public const HTTP_RESPONSE_STATUS_CODE = 'http.response.status_code';

    /** The `http.route` attribute: the endpoint's path as the API description gives it. */
    public const HTTP_ROUTE = 'http.route';

    /** The `server.address` attribute: the host of the client's base URL. */
    public const SERVER_ADDRESS = 'server.address';

    /** The `server.port` attribute: the port of the client's base URL. */
    public const SERVER_PORT = 'server.port';

    /** The `url.full` attribute: the URL of the first request, with the query of `url.query`. */
    public const URL_FULL = 'url.full';

    /** The `url.path` attribute: the path of the URL of the first request. */
    public const URL_PATH = 'url.path';

    /** The `url.query` attribute: the query of the URL of the first request, with only the parameters the endpoint defines. */
    public const URL_QUERY = 'url.query';

    /** The `url.scheme` attribute: the scheme of the URL of the first request. */
    public const URL_SCHEME = 'url.scheme';

    /**
     * The query parameters whose value is content: one that filters like a search, or one whose value comes from stored content. A query that has one of them is content, and so is the URL with that query.
     */
    private const CONTENT_QUERY_PARAMETERS = ['email', 'path_prefix', 'expected_content_sha256'];

    /** The headers of the W3C trace context and baggage, which an attempt off the API's origin never carries, whatever propagator is registered and whatever it does. */
    private const TRACE_CONTEXT_HEADERS = ['traceparent', 'tracestate', 'baggage'];

    /** The keys of a client's `openTelemetry` option. */
    private const CLIENT_OPTION_KEYS = ['tracerProvider', 'propagation', 'traces'];

    /** The keys of `traces`, in a client's `openTelemetry` option. */
    private const TRACES_KEYS = ['enabled', 'contentMode', 'maxContentBytes'];

    /** The keys of the `openTelemetry` request option. */
    private const REQUEST_OPTION_KEYS = ['conversationId'];

    /**
     * Whether a client's spans are enabled, from its `openTelemetry` option.
     *
     * `['traces' => ['enabled' => false]]` disables them, and so does `['traces' => false]`, which is short for it, or `false` for the whole option. The environment variable `ANTHROPIC_OPEN_TELEMETRY` set to `false` disables those of a client that is given no option, and a client that is given the option does not read it. A client asks once, when it is built, so the variable is read then and a later change to it does not reach the client. Throws when the option has a key it does not take, such as a misspelt one, or a value it does not accept, whether or not the spans are enabled.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function enabled(array|false|null $option): bool
    {
        // `false` is short for `['traces' => false]`.
        $settings = false === $option ? ['traces' => false] : ($option ?? []);
        self::rejectUnknownKeys('the `openTelemetry` client option', $settings, self::CLIENT_OPTION_KEYS);
        $provider = $settings['tracerProvider'] ?? null;
        if (!(is_null($provider) || $provider instanceof TracerProviderInterface)) {
            throw new \InvalidArgumentException("['tracerProvider'] of the `openTelemetry` client option must be a TracerProviderInterface, got ".get_debug_type($provider));
        }
        $propagation = $settings['propagation'] ?? null;
        if (!(is_null($propagation) || is_bool($propagation))) {
            throw new \InvalidArgumentException("['propagation'] of the `openTelemetry` client option must be a bool, got ".self::describe($propagation));
        }
        $traces = $settings['traces'] ?? null;
        if (!(is_null($traces) || is_bool($traces) || is_array($traces))) {
            throw new \InvalidArgumentException("['traces'] of the `openTelemetry` client option must be a bool or an array, got ".get_debug_type($traces));
        }
        $traces = self::tracesSettings($settings);
        self::rejectUnknownKeys("['traces'] of the `openTelemetry` client option", $traces, self::TRACES_KEYS);
        $enabled = $traces['enabled'] ?? null;
        if (!(is_null($enabled) || is_bool($enabled))) {
            throw new \InvalidArgumentException("['traces']['enabled'] of the `openTelemetry` client option must be a bool, got ".self::describe($enabled));
        }
        $mode = $traces['contentMode'] ?? null;
        if (!(is_null($mode) || 'metadata_only' === $mode || 'content' === $mode)) {
            throw new \InvalidArgumentException("['traces']['contentMode'] of the `openTelemetry` client option must be 'metadata_only' or 'content', got ".self::describe($mode));
        }
        $bytes = $traces['maxContentBytes'] ?? null;
        if (!(is_null($bytes) || (is_int($bytes) && $bytes >= 1))) {
            throw new \InvalidArgumentException("['traces']['maxContentBytes'] of the `openTelemetry` client option must be an integer of at least 1, got ".self::describe($bytes));
        }

        // The variable applies only to a client that is given no option.
        return $enabled ?? (!is_null($option) || 'false' !== strtolower(Util::getenv('ANTHROPIC_OPEN_TELEMETRY') ?? ''));
    }

    /**
     * Throws when the `openTelemetry` request option has a key it does not take, such as a misspelt one, or a `conversationId` that is no string, which would otherwise be ignored without notice. `RequestOptions` calls this wherever the option is set, and for every request.
     *
     * @param array<mixed>|null $option
     */
    public static function validateRequestOption(?array $option): void
    {
        self::rejectUnknownKeys('the `openTelemetry` request option', $option ?? [], self::REQUEST_OPTION_KEYS);
        $id = $option['conversationId'] ?? null;
        if (!(is_null($id) || is_string($id))) {
            throw new \InvalidArgumentException("['conversationId'] of the `openTelemetry` request option must be a string, got ".self::describe($id));
        }
    }

    /**
     * The tracer for one API call of a client whose spans are enabled.
     *
     * It comes from the `tracerProvider` of the client's `openTelemetry` option, or else from the tracer provider registered with the OpenTelemetry API when the call starts, so that a client created before the application registers its provider still emits spans.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function tracer(array|false|null $option): TracerInterface
    {
        $provider = is_array($option) ? ($option['tracerProvider'] ?? null) : null;

        return ($provider instanceof TracerProviderInterface ? $provider : Globals::tracerProvider())->getTracer(self::INSTRUMENTATION_SCOPE, \Anthropic\VERSION);
    }

    /**
     * Whether a client's spans carry content, from the `traces.contentMode` of its `openTelemetry` option: `'content'` does, and `'metadata_only'`, the default, does not. Like {@see self::enabled()}, a client asks once, when it is built.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function contentEnabled(array|false|null $option): bool
    {
        return 'content' === (self::tracesSettings($option)['contentMode'] ?? null);
    }

    /**
     * The most bytes that the content of one span holds, from the `traces.maxContentBytes` of a client's `openTelemetry` option, or null when the option sets none: the SDK's own bound then applies. Like {@see self::enabled()}, a client asks once, when it is built.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function maxContentBytes(array|false|null $option): ?int
    {
        $bytes = self::tracesSettings($option)['maxContentBytes'] ?? null;

        return is_int($bytes) && $bytes >= 1 ? $bytes : null;
    }

    /**
     * Whether the requests of a client's API calls carry the trace context of their call span, from the `propagation` of its `openTelemetry` option. The environment variable `ANTHROPIC_OPEN_TELEMETRY_PROPAGATION` set to `false` says that those of a client that is given no option do not, and a client that is given the option does not read it. Like {@see self::enabled()}, a client asks once, when it is built.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     */
    public static function propagates(array|false|null $option): bool
    {
        // The variable applies only to a client that is given no option.
        if (is_null($option)) {
            return 'false' !== strtolower(Util::getenv('ANTHROPIC_OPEN_TELEMETRY_PROPAGATION') ?? '');
        }

        return !is_array($option) || false !== ($option['propagation'] ?? null);
    }

    /**
     * Whether a client's spans carry content, as the client resolved it when it was built.
     */
    public static function recordsContent(BaseClient $client): bool
    {
        return $client->recordsContent();
    }

    /**
     * Starts the call span of an API call named `$name`, as a child of the current span, with `$attributes`: what is known of the call before it starts, such as the resource IDs in the request's path, as the SDK method named them. A sampler sees only the attributes a span starts with. Returns null when the request was not made through an SDK method and so has no span name, or when the span neither records nor propagates a trace context: such a span has no effect, so the API call runs as if tracing were off. It runs so too when starting the span throws. For a client whose requests carry no trace context (`$propagates` is false) the propagator is not asked, and a span that does not record is dropped only when its context is not valid: one with a valid context is still the current span while the attempts run, so that the application's HTTP instrumentation, which propagates for such a client, continues its trace with its sampling decision.
     *
     * @param array<non-empty-string,mixed> $attributes
     */
    public static function startApiCallSpan(TracerInterface $tracer, ?string $name, array $attributes = [], bool $propagates = true): ?SpanInterface
    {
        if (is_null($name) || '' === $name) {
            return null;
        }
        // An attribute holds a string, an integer, a float, a boolean or a list of strings: anything else is left out.
        $attributes = array_filter($attributes, static fn (mixed $value): bool => is_scalar($value) || (is_array($value) && array_is_list($value) && $value === array_filter($value, 'is_string')));

        try {
            $span = $tracer->spanBuilder($name)->setSpanKind(SpanKind::KIND_CLIENT)->setAttributes($attributes)->startSpan();
            if (!$span->isRecording() && ($propagates ? [] === self::injectContext($span) : !$span->getContext()->isValid())) {
                return null;
            }
        } catch (\Throwable) {
            // A sampler, a span processor or a propagator that throws must not fail the API call, which runs as if tracing were off.
            return null;
        }

        return $span;
    }

    /**
     * The attributes that the call span of an API call starts with besides those the SDK method named, for a client whose base URL is `$baseUrl`: its host, and its port or the port of its scheme when it gives none.
     *
     * @return array<non-empty-string,string|int>
     */
    public static function callSpanAttributes(UriInterface $baseUrl): array
    {
        return [
            self::SERVER_ADDRESS => trim($baseUrl->getHost(), '[]'),
            self::SERVER_PORT => $baseUrl->getPort() ?? ('http' === $baseUrl->getScheme() ? 80 : 443),
        ];
    }

    /**
     * The attributes that the call span of an API call starts with from the SDK method's request: its HTTP method and `$route`, the endpoint's path as the API description gives it, such as `/v1/files/{file_id}`. A request that was not made through an SDK method has no route.
     *
     * @return array<non-empty-string,string>
     */
    public static function requestAttributes(string $method, ?string $route): array
    {
        return [self::HTTP_REQUEST_METHOD => strtoupper($method), ...(is_null($route) ? [] : [self::HTTP_ROUTE => $route])];
    }

    /**
     * The `url.*` attributes of a call span whose API call sends its first request to `$url`. Of the query, the span gets only the parameters that the endpoint defines, `$queryNames`, as they were sent and in that order: a parameter is one of them when its whole name is, or when its name ends in `[]`, as an item of a list is sent, and the name without that ending is. The span has no `url.query` when none is left. `url.full` has that query too, so it can differ from `$url`. It has a port only when `$url` gives one, and never the user information.
     *
     * A query that keeps one of {@see self::CONTENT_QUERY_PARAMETERS}, or one of `$contentQueryNames`, the parameters that are content on this endpoint only, is content, so the span has neither `url.query` nor `url.full` unless the client's spans carry content (`$recordsContent`). Its other `url.*` attributes are the same either way.
     *
     * @param list<string> $queryNames
     * @param list<string> $contentQueryNames
     *
     * @return array<non-empty-string,string>
     */
    public static function urlAttributes(UriInterface $url, array $queryNames, bool $recordsContent = false, array $contentQueryNames = []): array
    {
        $kept = [];
        $isContent = false;
        foreach ('' === $url->getQuery() ? [] : explode('&', $url->getQuery()) as $parameter) {
            $name = rawurldecode(explode('=', $parameter, 2)[0]);
            // The parameter that the endpoint defines by this whole name, or else the list that a name ending in `[]` is an item of.
            $defined = in_array($name, $queryNames, strict: true) || !str_ends_with($name, '[]') ? $name : substr($name, 0, -2);
            if (in_array($defined, $queryNames, strict: true)) {
                $kept[] = $parameter;
                $isContent = $isContent || in_array($defined, self::CONTENT_QUERY_PARAMETERS, strict: true) || in_array($defined, $contentQueryNames, strict: true);
            }
        }
        $query = implode('&', $kept);
        $port = $url->getPort();
        $attributes = [self::URL_SCHEME => $url->getScheme(), self::URL_PATH => $url->getPath()];
        if ($isContent && !$recordsContent) {
            return $attributes;
        }

        return [
            ...$attributes,
            ...('' === $query ? [] : [self::URL_QUERY => $query]),
            self::URL_FULL => $url->getScheme().'://'.$url->getHost().(is_null($port) ? '' : ':'.$port).$url->getPath().('' === $query ? '' : '?'.$query),
        ];
    }

    /**
     * Records on `$span`, the call span, that its API call is about to send `$request`, as the HTTP client gets it, and counts it in `$sent`, which the client keeps for that one API call. The first request of an API call gives the span its `url.*` attributes ({@see self::urlAttributes()}), with `$queryNames`, the query parameters that the endpoint defines. Every later one, such as a retry, a fallback or the request that follows a redirect, leaves them as they are and adds one to `http.request.resend_count`, which a call that sends a single request does not have. `$recordsContent` says whether the client's spans carry content, which a query can be: `$contentQueryNames` are the query parameters that are content on this endpoint only.
     *
     * @param list<string> $queryNames
     * @param list<string> $contentQueryNames
     */
    public static function traceRequest(SpanInterface $span, RequestInterface $request, array $queryNames, SentRequests $sent, bool $recordsContent = false, array $contentQueryNames = []): void
    {
        try {
            if (!$span->isRecording()) {
                return;
            }
            if (0 === $sent->count) {
                $span->setAttributes(self::urlAttributes($request->getUri(), $queryNames, $recordsContent, $contentQueryNames));
            } else {
                $span->setAttribute(self::HTTP_REQUEST_RESEND_COUNT, $sent->count);
            }
            ++$sent->count;
        } catch (\Throwable) {
            // What the span cannot record must not fail the API call.
        }
    }

    /**
     * Returns the request to send for one attempt of an API call, whose headers carry the trace context of `$span`, the call span, as the propagator the application registered writes it, in place of any such headers already present. An attempt that follows a redirect off the API's origin (`$crossOrigin`) carries no trace context, as it carries no credentials: its request instead drops every header that holds one, both the fields the propagator lists and, unless `$propagates` is false, the headers it writes for `$span`, since a propagator may write headers it does not list, such as one per baggage entry. It drops `traceparent`, `tracestate` and `baggage` first and whatever the propagator does, so a propagator that throws on that attempt cannot leave the headers of an earlier one on it. Any other attempt of a client whose requests carry no trace context (`$propagates` is false) is sent as it is, and the propagator is not asked.
     */
    public static function traceAttempt(SpanInterface $span, RequestInterface $request, bool $crossOrigin, bool $propagates): RequestInterface
    {
        if ($crossOrigin) {
            // The W3C headers go first, and without asking the propagator, so that one that throws can only leave fewer headers on the request, never more.
            foreach (self::TRACE_CONTEXT_HEADERS as $name) {
                $request = $request->withoutHeader($name);
            }
            // Then whatever else the propagator lists or writes. Each is read by itself: one that throws does not keep the other from being dropped.
            $lists = [static fn (): array => Globals::propagator()->fields()];
            if ($propagates) {
                // A client that never asks the propagator to inject has none of the headers it writes.
                $lists[] = static fn (): array => array_keys(self::injectContext($span));
            }
            foreach ($lists as $names) {
                try {
                    foreach ($names() as $name) {
                        $request = $request->withoutHeader($name);
                    }
                } catch (\Throwable) {
                    // A propagator that throws must not fail the API call.
                }
            }

            return $request;
        }
        if (!$propagates) {
            return $request;
        }

        try {
            foreach (self::injectContext($span) as $name => $value) {
                $request = $request->withHeader($name, $value);
            }
        } catch (\Throwable) {
            // A propagator that throws must not fail the API call: the attempt is sent with the headers it has so far.
        }

        return $request;
    }

    /**
     * Ends `$span`, the call span of an API call that `$client` made as `$result['request']` with `$result['options']`, now that the call has a result: it failed with `$result['error']`, or `$result['response']` arrived and its body, if it was read, parsed to `$result['data']`. `$result['cancelled']` says that the application dropped the response of a streaming call without reading its stream: a cancellation, which has no status. `$client` made the call; an SDK's own `endApiCallSpan` reads its settings.
     *
     * A stream in `$result['data']` is yet to be read, so what comes back in its place is a stream that reads through to its events, or to `$result['events']` when an SDK has put a generator of its own in front of them. Reading that stream ends the span later: with status OK once the application has read the stream to the end, with an error when reading fails, and with no status when the application closes or drops it early. `$result['isComplete']`, for a stream that has an end event, says whether the events read so far include that event: then a stream the server ends before it is an `api_error`, and one that the application closes before the server ends it was cancelled, even after its last event. Without it, an event stream (a `text/event-stream` body) has no end of its own, so one the server ends keeps no status either: such a span is never OK. `$result['beforeEnd']` runs just before the span of a stream ends, however it ends: an SDK sets there what it records of a stream once reading is over. It must not throw.
     *
     * A method that creates one object names the attribute of that object's ID (the `createdId` of the API call that `$result['options']` name), which the span gets from the `id` of `$result['data']`, or from the field the method names with it. A call that failed has no `$result['data']`, and so no such attribute.
     *
     * Does nothing to a span that is not recording, such as one that already ended. Never throws, so that it can run just before the API call returns or throws, or while PHP frees a response.
     *
     * @param ApiCallResult $result
     *
     * @return mixed what to hand to the application: `$result['data']`, or the `TracedStream` that reads it
     */
    public static function endApiCallSpan(BaseClient $client, SpanInterface $span, array $result): mixed
    {
        $data = $result['data'] ?? null;

        try {
            if (!$span->isRecording()) {
                return $data;
            }
            $error = $result['error'] ?? null;
            $response = $result['response'] ?? ($error instanceof APIException ? $error->response : null);
            if (!is_null($response)) {
                $span->setAttribute(self::HTTP_RESPONSE_STATUS_CODE, $response->getStatusCode());
            }
            $createdId = $result['options']->apiCall()?->createdId;
            if (!is_null($createdId) && $data instanceof BaseModel) {
                // A membership, such as a workspace member, has the ID in a field like `user_id`.
                [$attribute, $field] = is_array($createdId) ? [array_key_first($createdId), current($createdId)] : [$createdId, 'id'];
                $id = is_string($field) ? (((array) $data->jsonSerialize())[$field] ?? null) : null;
                if (!is_null($attribute) && '' !== $attribute && is_string($id)) {
                    $span->setAttribute($attribute, $id);
                }
            }
            if ($data instanceof BaseStream) {
                $isEventStream = !is_null($response) && str_starts_with($response->getHeaderLine('Content-Type'), 'text/event-stream');

                return new TracedStream($data, self::iterateAndEndSpan($span, $result['events'] ?? $data->getIterator(), $result['isComplete'] ?? null, $isEventStream, $result['beforeEnd'] ?? null));
            }
            if (array_key_exists('error', $result)) {
                self::setErrorStatus($span, $error);
            } elseif (true !== ($result['cancelled'] ?? null)) {
                $span->setStatus(StatusCode::STATUS_OK);
            }
            $span->end();
        } catch (\Throwable) {
            // A span processor that throws, or anything else the span cannot record, must not replace the result or the exception of the API call.
        }

        return $data;
    }

    /**
     * Gives `$span` the status of an operation that failed with `$error`: `ERROR`, with `error.type` set to `$type` or else derived from `$error`.
     */
    public static function setErrorStatus(SpanInterface $span, ?\Throwable $error, ?string $type = null): void
    {
        $span->setStatus(StatusCode::STATUS_ERROR);
        $span->setAttribute(self::ERROR_TYPE, $type ?? self::errorType($error));
    }

    /**
     * The `traces` of a client's `openTelemetry` option as an array: `true` and `false` are short for `['enabled' => true]` and `['enabled' => false]`, and `false` for the whole option for `['enabled' => false]`. An array with no key when the option has no `traces`.
     *
     * @param OpenTelemetryOptions|array<string,mixed>|null $option
     *
     * @return array<mixed>
     */
    protected static function tracesSettings(array|false|null $option): array
    {
        $traces = false === $option ? false : ($option['traces'] ?? null);

        return is_bool($traces) ? ['enabled' => $traces] : (is_array($traces) ? $traces : []);
    }

    /**
     * A generator that reads through `$events`, the events of a stream, so that reading them ends `$span` as {@see self::endApiCallSpan()} describes.
     *
     * @template TKey
     * @template TEvent
     *
     * @param \Iterator<TKey, TEvent> $events
     * @param \Closure(): bool|null $isComplete
     * @param \Closure(): void|null $beforeEnd
     *
     * @return \Generator<TKey, TEvent>
     */
    private static function iterateAndEndSpan(SpanInterface $span, \Iterator $events, ?\Closure $isComplete, bool $isEventStream, ?\Closure $beforeEnd): \Generator
    {
        // Ends the span of a stream the application drops part-way or unread, when PHP frees the generator below
        // with it: a cancellation, which has no status, even after the last event. A `finally` block would
        // say the same, but PHP 8.3 can crash running one while it collects a dropped stream.
        $dropped = new class($span, $beforeEnd) {
            public bool $read = false;

            /**
             * @param \Closure(): void|null $beforeEnd
             */
            public function __construct(private SpanInterface $span, private ?\Closure $beforeEnd) {}

            /**
             * Ends the span, with no status, unless the reading ended it.
             */
            public function __destruct()
            {
                if ($this->read) {
                    return;
                }

                try {
                    if (!is_null($this->beforeEnd)) {
                        ($this->beforeEnd)();
                    }
                    $this->span->end();
                } catch (\Throwable) {
                    // PHP frees the stream wherever the application drops it: a span processor that throws must not throw from there.
                }
            }
        };

        return (static function () use ($span, $events, $isComplete, $isEventStream, $beforeEnd, $dropped): \Generator {
            $error = null;
            $readToTheEnd = false;

            try {
                foreach ($events as $key => $event) {
                    yield $key => $event;
                }
                $readToTheEnd = true;
            } catch (IteratorExit) {
                // `close()`: thrown in at the `yield`. A cancellation, which has no status, even after the last event.
            } catch (\Throwable $e) {
                // Reading failed: an `error` event, or a lost connection.
                $error = $e;
            }
            $dropped->read = true;

            try {
                if (!is_null($error)) {
                    self::setErrorStatus($span, $error);
                } elseif ($readToTheEnd) {
                    if (!is_null($isComplete)) {
                        if ($isComplete()) {
                            $span->setStatus(StatusCode::STATUS_OK);
                        } else {
                            // The application sees such a stream end without an error, so only the span fails. The server cut the stream short, so the failure is the API's.
                            self::setErrorStatus($span, null, 'api_error');
                        }
                    } elseif (!$isEventStream) {
                        $span->setStatus(StatusCode::STATUS_OK);
                    }
                    // An event stream without an end event is never complete: no status.
                }
                if (!is_null($beforeEnd)) {
                    $beforeEnd();
                }
                $span->end();
            } catch (\Throwable) {
                // What the span cannot record, or a span processor that throws, must not fail the application's reading of the stream, nor replace the error that failed it.
            }
            if (!is_null($error)) {
                throw $error;
            }
        })();
    }

    /**
     * Throws when `$value`, which is `$option`, has a key that is none of `$keys`. The message names the key and the keys that `$option` takes.
     *
     * @param array<mixed> $value
     * @param list<string> $keys
     */
    private static function rejectUnknownKeys(string $option, array $value, array $keys): void
    {
        foreach (array_keys($value) as $key) {
            if (!in_array($key, $keys, strict: true)) {
                throw new \InvalidArgumentException('Unknown key '.var_export($key, true)." in {$option}: the keys it takes are ".implode(', ', array_map(static fn (string $known): string => "'{$known}'", $keys)));
            }
        }
    }

    /**
     * `$value` as the message of a refused option names it: a scalar as PHP code spells it, and anything else by its type.
     */
    private static function describe(mixed $value): string
    {
        return is_scalar($value) ? var_export($value, true) : get_debug_type($value);
    }

    /**
     * The headers that carry `$span`'s trace context, from the propagator the application registered.
     *
     * @return array<string,string>
     */
    private static function injectContext(SpanInterface $span): array
    {
        $carrier = [];
        Globals::propagator()->inject($carrier, null, $span->storeInContext(Context::getCurrent()));
        $headers = [];
        foreach (is_array($carrier) ? $carrier : [] as $name => $value) {
            if (is_string($name) && is_string($value)) {
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    /**
     * The `error.type` of an operation that failed with `$error`. An error response has the type of its error envelope when the API sent one, and its status code otherwise.
     */
    private static function errorType(?\Throwable $error): string
    {
        if ($error instanceof APIStatusException) {
            // The envelope is the response body, or the `error` event that failed a stream.
            $type = Util::dig(Util::dig($error->body, 'error'), 'type');
            $type = is_string($type) && '' !== $type ? $type : $error->type?->value;
            if (!is_null($type)) {
                return $type;
            }
        }

        return match (true) {
            $error instanceof APITimeoutException => 'client_timeout_error',
            $error instanceof APIConnectionException => 'connection_error',
            $error instanceof APIException && !is_null($error->status) => (string) $error->status,
            default => 'client_error',
        };
    }
}
