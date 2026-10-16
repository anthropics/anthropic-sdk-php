<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Core\Contracts\BasePage;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\RetryableException;
use Anthropic\Core\Implementation\RawResponse;
use Anthropic\Core\Implementation\SentRequests;
use Anthropic\Lib\Tracing\Tracing;
use Anthropic\RequestOptions;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 *
 * @phpstan-type NormalizedRequest = array{
 *   method: string,
 *   path: string,
 *   query: array<string,mixed>,
 *   headers: array<string,string|null|list<string>>,
 *   body: mixed,
 * }
 * @phpstan-type OpenTelemetryOptions = array{
 *   tracerProvider?: TracerProviderInterface|null,
 *   propagation?: bool|null,
 *   traces?: bool|array{enabled?: bool|null, contentMode?: 'metadata_only'|'content'|null, maxContentBytes?: int<1, max>|null}|null,
 * }|false
 */
abstract class BaseClient
{
    /** Credential-bearing headers, never sent once a redirect chain has left the original origin. */
    private const REDIRECT_SENSITIVE_HEADERS = [
        'authorization',
        'proxy-authorization',
        'api-key',
        'x-api-key',
        'x-amz-security-token',
        'cookie',
        'set-cookie',
    ];

    /**
     * @internal
     *
     * @var OpenTelemetryOptions|null
     */
    public readonly array|false|null $openTelemetry;

    private UriInterface $baseUrl;

    /**
     * Whether this client's spans are enabled, as its option said when it was built, or `ANTHROPIC_OPEN_TELEMETRY` for a client that is given no option.
     */
    private bool $traces;

    /**
     * Whether this client's requests carry the trace context of their call span, as its option said when it was built, or `ANTHROPIC_OPEN_TELEMETRY_PROPAGATION` for a client that is given no option.
     */
    private bool $propagates;

    /**
     * Whether this client's spans carry content, as its option said when it was built, or `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` for a client that is given no option.
     */
    private bool $recordsContent;

    /**
     * The most bytes that the content of one of this client's spans holds, as its option said when it was built, or `ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES` for a client that is given no option, or null for the SDK's own bound.
     */
    private ?int $maxContentBytes;

    /**
     * @internal
     *
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param OpenTelemetryOptions|null $openTelemetry OpenTelemetry tracing of this client's API calls. Each call emits a span when the application has registered a tracer provider with the OpenTelemetry API. `false`, short for `['traces' => false]`, disables the spans, and `['traces' => false]` is itself short for `['traces' => ['enabled' => false]]`. `traces.contentMode` set to `'content'` adds the content of requests and responses to the spans, within `traces.maxContentBytes` bytes for each span when it is set. `propagation` set to `false` sends the requests without the trace context of their span, for an application whose HTTP client instrumentation already propagates it, so that a request does not carry it twice. The environment variables `ANTHROPIC_OPEN_TELEMETRY`, `ANTHROPIC_OPEN_TELEMETRY_PROPAGATION`, `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` and `ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES` set `traces.enabled`, `propagation`, `traces.contentMode` and `traces.maxContentBytes` for a client that is given no option, which reads them once, when it is built. A client that is given the option does not read them: what the option leaves unset has its default.
     */
    public function __construct(
        protected array $headers,
        string $baseUrl,
        protected ?string $idempotencyHeader = null,
        protected RequestOptions $options = new RequestOptions,
        array|false|null $openTelemetry = null,
    ) {
        assert(!is_null($this->options->uriFactory));
        $this->baseUrl = $this->options->uriFactory->createUri($baseUrl);
        $this->openTelemetry = $openTelemetry;
        // The settings are resolved here, once: an environment variable that changes later does not change this client.
        $this->traces = Tracing::enabled($openTelemetry);
        $this->propagates = Tracing::propagates($openTelemetry);
        $this->recordsContent = Tracing::contentEnabled($openTelemetry);
        $this->maxContentBytes = Tracing::maxContentBytes($openTelemetry);
    }

    /**
     * @internal
     *
     * Whether this client's spans carry the content of requests and responses, as resolved when the client was built
     */
    public function recordsContent(): bool
    {
        return $this->recordsContent;
    }

    /**
     * @internal
     *
     * Whether this client's requests carry the trace context of their call span, as resolved when the client was built
     */
    public function propagates(): bool
    {
        return $this->propagates;
    }

    /**
     * @internal
     *
     * The most bytes that the content of one of this client's spans holds, as resolved when the client was built, or null for the SDK's own bound
     */
    public function maxContentBytes(): ?int
    {
        return $this->maxContentBytes;
    }

    /**
     * @internal
     *
     * The tracer for one API call, from the tracer provider the application has registered by the time the call starts, or null when this client's spans are disabled, or when the tracer provider throws
     */
    public function tracer(): ?TracerInterface
    {
        try {
            return $this->traces ? Tracing::clientTracer($this) : null;
        } catch (\Throwable) {
            // A tracer provider that throws must not fail the API call, which runs as if this client's spans were disabled.
            return null;
        }
    }

    /**
     * @internal
     *
     * The headers that `request()` sends for a call with `$headers` and `$options`, merged with this client's own. An SDK method that starts its own call span reads them first, since a span starts with everything known of its call
     *
     * @param array<string,mixed> $headers
     *
     * @return array<string,string|list<string>|null>
     */
    public function mergedHeaders(array $headers, RequestOptions $options): array
    {
        // @phpstan-ignore argument.type
        return $this->buildRequest(method: 'get', path: '', query: [], headers: $headers, body: null, opts: $options)[0]['headers'];
    }

    /**
     * @internal
     *
     * The options that `request()` uses for a call with `$options`: this client's own, then the call's. An SDK method that starts its own call span reads them first, since a span starts with everything known of its call
     *
     * @param RequestOpts|null $options
     */
    public function mergedOptions(RequestOptions|array|null $options): RequestOptions
    {
        return RequestOptions::parse($this->options, $options);
    }

    /**
     * @internal
     */
    public function nextPageUrl(string $reference): string
    {
        $base = $this->baseUrl;
        $uri = Util::resolveUri($base, reference: $reference);
        // The follow-up request carries this client's credentials, so a response must not steer it to another
        // scheme, host, port or userinfo. The message leaves the URL out because it may hold a token.
        if ($uri->getScheme() !== $base->getScheme() || $uri->getAuthority() !== $base->getAuthority()) {
            throw new \RuntimeException('The next page URL points away from the client base URL');
        }

        return $uri->withFragment('')->__toString();
    }

    /**
     * @param string|list<mixed> $path
     * @param array<string,mixed> $query
     * @param array<string,mixed> $headers
     * @param string|int|list<string|int>|null $unwrap
     * @param class-string<BasePage<mixed>>|null $page
     * @param class-string<BaseStream<mixed>>|null $stream
     * @param RequestOptions|array<string,mixed>|null $options
     *
     * @return BaseResponse<mixed>
     */
    public function request(
        string $method,
        string|array $path,
        array $query = [],
        array $headers = [],
        mixed $body = null,
        string|int|array|null $unwrap = null,
        string|Converter|ConverterSource|null $convert = null,
        ?string $page = null,
        ?string $stream = null,
        RequestOptions|array|null $options = [],
    ): BaseResponse {
        $startTime = hrtime(true);
        // What the SDK method that makes the request says of its call, for the call span. A request that was not made through an SDK method says nothing, and has no span.
        $call = $options instanceof RequestOptions ? $options->apiCall() : null;
        // A span the SDK method started is this call's to end, whatever fails, even before a request exists.
        $span = $call?->span;
        // The span belongs to this request only. The options go on to the middleware, and to the request for a later page of a list, whose span has the name, the route, the query names and the resource IDs too.
        $call = $call?->withoutSpan();
        $scope = null;

        try {
            [$req, $opts, $uri] = $this->buildRequest(
                method: $method,
                // @phpstan-ignore argument.type
                path: $path,
                query: $query,
                // @phpstan-ignore argument.type
                headers: $headers,
                body: $body,
                // @phpstan-ignore argument.type
                opts: $options,
            );
            ['method' => $method, 'headers' => $headers, 'body' => $data] = $req;
            if (!is_null($span)) {
                $opts = $opts->withApiCall($call);
            }
            assert(!is_null($opts->requestFactory));
            $request = $opts->requestFactory->createRequest($method, uri: $uri);
            $request = Util::withSetHeaders($request, headers: $headers);

            // A file part that reads from a pipe or socket can be encoded only once, so such a request gets a single
            // attempt: whatever that attempt throws is surfaced instead of retried, even when retries were asked for.
            $sendOpts = Util::hasNonSeekableFilePart($data) ? $opts->withMaxRetries(0) : $opts;

            if (is_null($span)) {
                $tracer = $this->tracer();
                $span = is_null($tracer) ? null : Tracing::startApiCallSpan($tracer, $call?->name, [...Tracing::requestAttributes($method, $call?->route), ...($call->attributes ?? []), ...Tracing::apiCallSpanAttributes($this, $opts)], $this->propagates);
            }

            // The call span is the current span while the attempts run, so that the application's HTTP instrumentation parents their spans to it.
            try {
                $scope = $span?->activate();
            } catch (\Throwable) {
                // A context storage that throws must not fail the API call: the attempts run with the span not current.
            }

            // @phpstan-ignore-next-line argument.type
            $rsp = $this->sendRequest($sendOpts, req: $request, data: $data, redirectCount: 0, retryCount: 0, crossOrigin: false, span: $span);
        } catch (\Throwable $e) {
            if (!is_null($span)) {
                // A request that could not be built is recorded with what the method passed in.
                $req ??= ['method' => $method, 'path' => '', 'query' => $query, 'headers' => [], 'body' => $body];
                Tracing::endApiCallSpan($this, $span, ['request' => $req, 'options' => ($opts ?? $this->options)->withApiCall($call), 'startTime' => $startTime, 'error' => $e]);
            }

            throw $e;
        } finally {
            try {
                $scope?->detach();
            } catch (\Throwable) {
                // Nor may it replace the result or the exception of the API call.
            }
        }

        // @phpstan-ignore-next-line argument.type
        return new RawResponse(client: $this, request: $request, response: $rsp, options: $opts, requestInfo: $req, unwrap: $unwrap, stream: $stream, page: $page, convert: $convert ?? 'null', span: $span, startTime: $startTime);
    }

    /**
     * Returns the base URL for API requests.
     *
     * Subclasses can override this to provide dynamic URLs based on
     * configuration (e.g., region-specific endpoints for Bedrock/Vertex).
     *
     * @internal
     */
    public function getBaseUrl(): UriInterface
    {
        return $this->baseUrl;
    }

    /**
     * @internal
     */
    protected function generateIdempotencyKey(): string
    {
        $hex = bin2hex(random_bytes(32));

        return "stainless-php-retry-{$hex}";
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions, string}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        $options = RequestOptions::parse($this->options, $opts);

        $body = Util::mergeBody($body, extraBody: $options->extraBodyParams);

        $parsedPath = Util::parsePath($path);

        /** @var array<string,mixed> $mergedQuery */
        $mergedQuery = array_merge_recursive(
            $query,
            $options->extraQueryParams ?? []
        );
        $uri = Util::joinUri($this->getBaseUrl(), path: $parsedPath, query: $mergedQuery)->__toString();
        $idempotencyHeaders = $this->idempotencyHeader && !array_key_exists($this->idempotencyHeader, array: $headers)
            ? [$this->idempotencyHeader => $this->generateIdempotencyKey()]
            : [];

        // Generated services place their per-endpoint default `anthropic-beta`
        // header in `$options->extraHeaders` (so callers can override it via
        // request options), while the user-supplied `betas:` request param is
        // translated into `$headers['anthropic-beta']`. Because `extraHeaders`
        // is spread last below it would silently replace a caller's `betas:`.
        // Combine the two instead so both the caller's betas and the
        // per-endpoint default are sent, matching other Anthropic SDKs.
        $betaHeaders = self::mergeBetaHeaders($headers, extraHeaders: $options->extraHeaders ?? []);

        /** @var array<string,string|list<string>|null> $mergedHeaders */
        $mergedHeaders = [
            ...$this->headers,
            ...$headers,
            ...($options->extraHeaders ?? []),
            ...$betaHeaders,
            ...$idempotencyHeaders,
        ];

        $req = ['method' => strtoupper($method), 'path' => $parsedPath, 'query' => $mergedQuery, 'headers' => $mergedHeaders, 'body' => $body];

        return [$req, $options, $uri];
    }

    /**
     * Transforms the request before it is sent.
     *
     * This method must be idempotent as it may be called multiple times during
     * request retries. Use withHeader() to replace existing headers rather than
     * addHeader() to prevent header accumulation.
     */
    protected function transformRequest(
        RequestInterface $request
    ): RequestInterface {
        return $request;
    }

    /**
     * @internal
     *
     * @return list<\Anthropic\Middleware>
     */
    protected function backendMiddleware(): array
    {
        return [];
    }

    /**
     * @internal
     *
     * @return array{RequestInterface, bool}
     */
    protected function followRedirect(
        ResponseInterface $rsp,
        RequestInterface $req
    ): array {
        $location = $rsp->getHeaderLine('Location');
        if (!$location) {
            throw new APIConnectionException($req, message: 'Redirection without Location header');
        }

        // RFC 3986 resolution, not a merge: an absolute Location must not inherit $from's query or userinfo.
        $from = $req->getUri();

        try {
            $uri = Util::resolveUri($from, reference: $location);
        } catch (\InvalidArgumentException $e) {
            throw new APIConnectionException($req, previous: $e, message: 'Redirection with unparseable Location header');
        }
        // Same allowlist as Guzzle's redirect middleware: a 3xx must not steer the client to file://, gopher://, etc.
        if (!in_array($uri->getScheme(), ['http', 'https'], strict: true)) {
            throw new APIConnectionException($req, message: 'Redirection to unsupported scheme');
        }
        $redirect = $req->withUri($uri);
        $crossOrigin = $uri->getScheme() !== $from->getScheme() || $uri->getHost() !== $from->getHost() || $uri->getPort() !== $from->getPort();

        // Like browsers and Guzzle: a 303, or a 301/302 answering a non-GET/HEAD request, is refetched with a bodyless GET.
        $code = $rsp->getStatusCode();
        $method = strtoupper($req->getMethod());
        if ((301 == $code || 302 == $code || 303 == $code) && 'GET' !== $method && 'HEAD' !== $method) {
            $redirect = $redirect->withMethod('GET')->withoutHeader('Content-Type')->withoutHeader('Content-Length');
        }

        return [$redirect, $crossOrigin];
    }

    /**
     * @internal
     */
    protected function shouldRetry(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp,
        bool $wantsRetryFromException = false,
    ): bool {
        if ($retryCount >= ($opts->maxRetries ?? RequestOptions::DEFAULT_MAX_RETRIES)) {
            return false;
        }

        // A middleware threw RetryableException to opt this attempt back
        // into the retry policy; only maxRetries gates it (no response).
        if ($wantsRetryFromException) {
            return true;
        }

        // No response means the transport failed (connection refused/reset, DNS, TLS, timeout).
        if (is_null($rsp)) {
            return true;
        }

        // Note this is not a standard header. If the server explicitly says whether to retry, obey.
        $shouldRetryHeader = $rsp->getHeaderLine('x-should-retry');
        if ('true' === $shouldRetryHeader) {
            return true;
        }
        if ('false' === $shouldRetryHeader) {
            return false;
        }

        $code = $rsp->getStatusCode();

        // Retry on request timeouts, lock timeouts, rate limits and internal errors.
        return 408 == $code || 409 == $code || 429 == $code || $code >= 500;
    }

    /**
     * @internal
     */
    protected function retryDelay(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp
    ): float {
        $retryAfter = null;

        // Note the `retry-after-ms` header may not be standard, but is a good idea and we'd like proactive support for it.
        $header = $rsp?->getHeaderLine('retry-after-ms');
        if (is_numeric($header)) {
            $retryAfter = floatval($header) / 1000;
        } elseif (($header = $rsp?->getHeaderLine('retry-after') ?? '') !== '') {
            // About the Retry-After header: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Retry-After
            if (is_numeric($header)) {
                $retryAfter = floatval($header);
            } elseif (($date = strtotime($header)) !== false) {
                $retryAfter = (float) ($date - time());
            }
        }

        // If the API asks us to wait a certain amount of time, do what it says; otherwise calculate a default backoff.
        if (!is_null($retryAfter) && $retryAfter > 0) {
            return $retryAfter;
        }

        // Exponential backoff capped at maxRetryDelay, with up to 25% downward jitter.
        $delay = min(($opts->initialRetryDelay ?? RequestOptions::DEFAULT_INITIAL_RETRY_DELAY) * 2 ** $retryCount, $opts->maxRetryDelay ?? RequestOptions::DEFAULT_MAX_RETRY_DELAY);
        $jitter = 1 - 0.25 * mt_rand() / mt_getrandmax();

        return $delay * $jitter;
    }

    /**
     * @internal
     */
    protected function sleep(float $seconds): void
    {
        if ($seconds <= 0) {
            return;
        }

        $whole = (int) floor($seconds);
        time_nanosleep($whole, nanoseconds: (int) (($seconds - $whole) * 1e9));
    }

    /**
     * @internal
     *
     * @param bool|int|float|string|resource|\Traversable<mixed,>|array<string,mixed>|null $data
     * @param SpanInterface|null $span the call span, whose trace context each attempt carries. The query parameters that its `url.query` has are those that the API call of `$opts` names.
     * @param SentRequests|null $spanRequests how many requests this API call has sent, for the span's `url.*` attributes and resend count: null on the first attempt, which starts the count that every later attempt gets
     */
    protected function sendRequest(
        RequestOptions $opts,
        RequestInterface $req,
        mixed $data,
        int $retryCount,
        int $redirectCount,
        bool $crossOrigin,
        ?SpanInterface $span = null,
        ?SentRequests $spanRequests = null,
    ): ResponseInterface {
        $spanRequests ??= new SentRequests;
        $call = $opts->apiCall();
        $defaultTransporter = $opts->transporter;
        $streamingTransporter = $opts->streamingTransporter ?? $defaultTransporter;
        assert(null !== $opts->streamFactory && null !== $defaultTransporter && null !== $streamingTransporter);

        /** @var RequestInterface */
        $req = $req->withHeader('X-Stainless-Retry-Count', strval($retryCount));
        if (!is_null($span)) {
            $req = Tracing::traceAttempt($span, $req, crossOrigin: $crossOrigin, propagates: $this->propagates);
        }
        $req = Util::withSetBody($opts->streamFactory, req: $req, body: $data);
        // A retry or redirect reuses the stream the previous attempt read from, and PSR-18 clients are not required to rewind it.
        $body = $req->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        // The innermost step: per-backend signing and the actual HTTP
        // send. Middleware wraps around this, so request modifications it
        // makes are signed by transformRequest() here, per attempt.
        $sendRequest = function (RequestInterface $req) use ($defaultTransporter, $streamingTransporter, $crossOrigin, $span, $call, $spanRequests): ResponseInterface {
            // Rewind the request body when a prior send consumed it — a
            // custom-retry middleware calling callNext more than once, or
            // stream reuse across SDK retries/redirects — so the full body
            // is re-sent and per-attempt signing hashes it from the start.
            $body = $req->getBody();
            if ($body->isSeekable() && 0 !== $body->tell()) {
                $body->rewind();
            }

            $req = $this->transformRequest($req);
            // transformRequest() may sign each attempt, but credentials must never follow a redirect chain off the original origin.
            if ($crossOrigin) {
                // SigV4 signing sends temporary credentials' session token in its own header.
                foreach ([...self::REDIRECT_SENSITIVE_HEADERS, 'X-Amz-Security-Token'] as $header) {
                    $req = $req->withoutHeader($header);
                }
            }

            $transporter = Util::isStreamingRequest($req) ? $streamingTransporter : $defaultTransporter;
            // The call span has the URL of the first request as it is sent, after any middleware rewrote it, and counts every request after it.
            if (!is_null($span)) {
                Tracing::traceRequest($span, $req, $call->query ?? [], $spanRequests, recordsContent: Tracing::recordsContent($this), contentQueryNames: $call->contentQuery ?? []);
            }

            // Middleware can send a request once `request()` has returned, as a fallback request is sent while the application reads the stream: the call span is made current for it too.
            $scope = null;

            try {
                $scope = is_null($span) || Span::getCurrent() === $span ? null : $span->activate();
            } catch (\Throwable) {
                // A context storage that throws must not fail the API call.
            }

            try {
                return $transporter->sendRequest($req);
            } finally {
                try {
                    $scope?->detach();
                } catch (\Throwable) {
                    // Nor may it replace the response or the exception of the request.
                }
            }
        };

        // RequestOptions::parse merges by replacement, but middleware
        // stacks compose: request-level middleware runs inside (after)
        // client-level middleware rather than replacing it.
        $middleware = $opts->middleware ?? [];
        $clientMiddleware = $this->options->middleware ?? [];
        if ($middleware !== $clientMiddleware && [] !== $clientMiddleware) {
            $middleware = [...$clientMiddleware, ...$middleware];
        }
        $sendRequest = $this->applyMiddleware($sendRequest, middleware: [...$middleware, ...$this->backendMiddleware()], options: $opts);

        $rsp = null;
        $err = null;
        $middlewareRetry = null;

        try {
            $rsp = $sendRequest($req);
        } catch (RetryableException $e) {
            $middlewareRetry = $e;
        } catch (ClientExceptionInterface $e) {
            $err = $e;
        }

        $code = $rsp?->getStatusCode();

        if ($code >= 300 && $code < 400) {
            if ($redirectCount >= 20) {
                throw new APIConnectionException($req, message: 'Maximum redirects exceeded');
            }

            [$redirect, $leftOrigin] = $this->followRedirect($rsp, req: $req);
            if ($redirect->getMethod() !== $req->getMethod()) {
                // Rewritten to GET: this hop carries no body.
                $redirect = $redirect->withBody($opts->streamFactory->createStream());
                $data = null;
            } elseif (!$body->isSeekable()) {
                throw new APIConnectionException($req, message: 'Redirection requires resending a body that cannot be rewound');
            }

            return $this->sendRequest($opts, req: $redirect, data: $data, retryCount: $retryCount, redirectCount: ++$redirectCount, crossOrigin: $crossOrigin || $leftOrigin, span: $span, spanRequests: $spanRequests);
        }

        // A body that cannot seek cannot be replayed, so a retry could send it empty or truncated.
        if (($code >= 400 || is_null($rsp)) && $body->isSeekable() && $this->shouldRetry($opts, retryCount: $retryCount, rsp: $rsp, wantsRetryFromException: null !== $middlewareRetry)) {
            $seconds = $this->retryDelay($opts, retryCount: $retryCount, rsp: $rsp);

            // Release the connection before sleeping so it can be reused for the retry.
            $rsp?->getBody()->close();
            $this->sleep($seconds);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: ++$retryCount, redirectCount: $redirectCount, crossOrigin: $crossOrigin, span: $span, spanRequests: $spanRequests);
        }

        // Not retrying: a middleware RetryableException surfaces as-is, a
        // connection failure as APIConnectionException, an error status as
        // APIStatusException.
        if (null !== $middlewareRetry) {
            throw $middlewareRetry;
        }

        if ($code >= 400 || is_null($rsp)) {
            throw is_null($rsp)
                ? new APIConnectionException($req, previous: $err)
                : APIStatusException::from(request: $req, response: $rsp);
        }

        return $rsp;
    }

    /**
     * Wrap the core send step with the configured middleware so that
     * the first entry in the list runs outermost and the last runs closest
     * to the transport.
     *
     * @internal
     *
     * @param \Closure(RequestInterface): ResponseInterface $sendRequest
     * @param list<\Anthropic\Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface, RequestOptions=): ResponseInterface> $middleware
     *
     * @return \Closure(RequestInterface): ResponseInterface
     */
    private function applyMiddleware(\Closure $sendRequest, array $middleware, RequestOptions $options): \Closure
    {
        foreach (array_reverse($middleware) as $mw) {
            $next = $sendRequest;
            $sendRequest = $mw instanceof \Anthropic\Middleware
                // The interface declares two parameters so existing
                // implementations stay valid; the pipeline still passes the
                // attempt's options third, and implementations opt in by
                // declaring an optional third parameter (see Middleware).
                // @phpstan-ignore arguments.count
                ? static fn (RequestInterface $req): ResponseInterface => $mw->handle($req, $next, $options)
                : static fn (RequestInterface $req): ResponseInterface => $mw($req, $next, $options);
        }

        return $sendRequest;
    }

    /**
     * Combine `anthropic-beta` values from request headers (derived from the
     * `betas:` request param) with those in `extraHeaders` (per-endpoint
     * defaults and/or caller overrides). Returns an array containing a single
     * merged `anthropic-beta` entry when both sources provide a value;
     * otherwise an empty array so the standard merge order applies unchanged.
     *
     * @internal
     *
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param array<string,string|int|list<string|int>|null> $extraHeaders
     *
     * @return array<string,list<string>>
     */
    private static function mergeBetaHeaders(array $headers, array $extraHeaders): array
    {
        $key = 'anthropic-beta';
        if (!array_key_exists($key, $headers) || !array_key_exists($key, $extraHeaders)) {
            return [];
        }

        $normalize = static function (string|int|array|null $value): array {
            if (is_null($value)) {
                return [];
            }
            $values = is_array($value) ? $value : [$value];

            return array_merge(
                ...array_map(static fn ($v) => array_map('trim', explode(',', Util::strVal($v))), $values),
            );
        };

        $merged = array_values(array_unique([
            ...$normalize($headers[$key]),
            ...$normalize($extraHeaders[$key]),
        ]));

        return [] === $merged ? [] : [$key => [implode(',', $merged)]];
    }
}
