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
use Anthropic\Core\Implementation\RawResponse;
use Anthropic\Middleware;
use Anthropic\RequestOptions;
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
 */
abstract class BaseClient
{
    private UriInterface $baseUrl;

    /**
     * @internal
     *
     * @param array<string,string|int|list<string|int>|null> $headers
     */
    public function __construct(
        protected array $headers,
        string $baseUrl,
        protected ?string $idempotencyHeader = null,
        protected RequestOptions $options = new RequestOptions,
    ) {
        assert(!is_null($this->options->uriFactory));
        $this->baseUrl = $this->options->uriFactory->createUri($baseUrl);
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
        [$req, $opts] = $this->buildRequest(
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
        ['method' => $method, 'path' => $uri, 'headers' => $headers, 'body' => $data] = $req;
        assert(!is_null($opts->requestFactory));

        $request = $opts->requestFactory->createRequest($method, uri: $uri);
        $request = Util::withSetHeaders($request, headers: $headers);

        // @phpstan-ignore-next-line argument.type
        $rsp = $this->sendRequest($opts, req: $request, data: $data, redirectCount: 0, retryCount: 0);

        // @phpstan-ignore-next-line argument.type
        return new RawResponse(client: $this, request: $request, response: $rsp, options: $opts, requestInfo: $req, unwrap: $unwrap, stream: $stream, page: $page, convert: $convert ?? 'null');
    }

    /**
     * The middleware configured on this client, in outermost-first order
     * (the first entry wraps all the others).
     *
     * @return list<Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface>
     */
    public function middleware(): array
    {
        return $this->options->middleware ?? [];
    }

    /**
     * Derive a copy of this client with additional middleware appended after
     * (i.e. running inside) the client's existing middleware — the same
     * placement as request-level middleware. The original client is unchanged.
     *
     * Note: passing `middleware` through per-request `RequestOptions` instead
     * *replaces* the client's middleware (consistent with every other option),
     * silently dropping client-level middleware such as logging or tracing —
     * prefer `withMiddleware()` to append.
     *
     * Relies on each concrete client's `__clone()` to give the copy its own
     * options and to rewire its services to dispatch through the copy.
     *
     * @param Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface ...$middleware
     */
    public function withMiddleware(Middleware|callable ...$middleware): static
    {
        $self = clone $this;
        $self->options->middleware = array_values(
            array_merge($this->options->middleware ?? [], $middleware),
        );

        return $self;
    }

    /**
     * Returns the base URL for API requests.
     *
     * Subclasses can override this to provide dynamic URLs based on
     * configuration (e.g., region-specific endpoints for Bedrock/Vertex).
     *
     * @internal
     */
    protected function getBaseUrl(): UriInterface
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
     * @return array{NormalizedRequest, RequestOptions}
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

        $req = ['method' => strtoupper($method), 'path' => $uri, 'query' => $mergedQuery, 'headers' => $mergedHeaders, 'body' => $body];

        return [$req, $options];
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
     */
    protected function followRedirect(
        ResponseInterface $rsp,
        RequestInterface $req
    ): RequestInterface {
        $location = $rsp->getHeaderLine('Location');
        if (!$location) {
            throw new APIConnectionException($req, message: 'Redirection without Location header');
        }

        $uri = Util::joinUri($req->getUri(), path: $location);

        return $req->withUri($uri);
    }

    /**
     * @internal
     */
    protected function shouldRetry(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp
    ): bool {
        if ($retryCount >= $opts->maxRetries) {
            return false;
        }

        $code = $rsp?->getStatusCode();
        if (408 == $code || 409 == $code || 429 == $code || $code >= 500) {
            return true;
        }

        return false;
    }

    /**
     * @internal
     */
    protected function retryDelay(
        RequestOptions $opts,
        int $retryCount,
        ?ResponseInterface $rsp
    ): float {
        if (!empty($header = $rsp?->getHeaderLine('retry-after'))) {
            if (is_numeric($header)) {
                return floatval($header);
            }

            try {
                $date = new \DateTimeImmutable($header);
                $span = time() - $date->getTimestamp();

                return max(0.0, $span);
            } catch (\DateMalformedStringException) {
            }
        }

        $scale = $retryCount ** 2;
        $jitter = 1 - (0.25 * mt_rand() / mt_getrandmax());
        $naive = $opts->initialRetryDelay * $scale * $jitter;

        return max(0.0, min($naive, $opts->maxRetryDelay));
    }

    /**
     * @internal
     *
     * @param bool|int|float|string|resource|\Traversable<mixed,>|array<string,mixed>|null $data
     */
    protected function sendRequest(
        RequestOptions $opts,
        RequestInterface $req,
        mixed $data,
        int $retryCount,
        int $redirectCount,
    ): ResponseInterface {
        assert(null !== $opts->streamFactory && null !== $opts->transporter);

        /** @var RequestInterface */
        $req = $req->withHeader('X-Stainless-Retry-Count', strval($retryCount));
        $req = Util::withSetBody($opts->streamFactory, req: $req, body: $data);

        // The innermost handler: per-backend request signing / URL-rewriting
        // and the actual HTTP send. Middleware wraps *around* this, so it sees
        // the canonical request shape, and any request modifications it makes
        // (e.g. `withHeader(...)`) are signed by `transformRequest()` here, per
        // attempt. `callNext` returns the response for every HTTP status; only
        // a transport-level failure raises.
        $callNext = function (RequestInterface $req) use ($opts): ResponseInterface {
            // Rewind the (seekable) body before each invocation so a custom-retry
            // middleware that calls callNext more than once re-sends the full
            // body, and so per-attempt signing in transformRequest() hashes it
            // from the start. Non-seekable bodies can't be rewound (and aren't
            // re-sendable); that limitation is fundamental.
            $body = $req->getBody();
            if ($body->isSeekable()) {
                $body->rewind();
            }

            $req = $this->transformRequest($req);

            $transporter = Util::isStreamingRequest($req)
                ? ($opts->streamingTransporter ?? $opts->transporter)
                : $opts->transporter;

            return $transporter->sendRequest($req);
        };

        $handler = $this->applyMiddleware($callNext, $opts->middleware ?? []);

        $rsp = null;
        $err = null;

        try {
            $rsp = $handler($req);
        } catch (ClientExceptionInterface $e) {
            $err = $e;
        }

        $code = $rsp?->getStatusCode();

        if ($code >= 300 && $code < 400) {
            if ($redirectCount >= 20) {
                throw new APIConnectionException($req, message: 'Maximum redirects exceeded');
            }

            $req = $this->followRedirect($rsp, req: $req);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: $retryCount, redirectCount: ++$redirectCount);
        }

        if ($code >= 400 || is_null($rsp)) {
            if (!$this->shouldRetry($opts, retryCount: $retryCount, rsp: $rsp)) {
                $exn = is_null($rsp) ? new APIConnectionException($req, previous: $err) : APIStatusException::from(request: $req, response: $rsp);

                throw $exn;
            }

            $seconds = $this->retryDelay($opts, retryCount: $retryCount, rsp: $rsp);
            $floor = floor($seconds);
            time_nanosleep((int) $floor, nanoseconds: (int) ($seconds - $floor) * 10 ** 9);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: ++$retryCount, redirectCount: $redirectCount);
        }

        return $rsp;
    }

    /**
     * Wrap the core request handler with the configured middleware so that the
     * first middleware in the list runs outermost and the last runs closest to
     * the transport.
     *
     * @internal
     *
     * @param \Closure(RequestInterface): ResponseInterface $handler
     * @param list<Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface> $middleware
     *
     * @return \Closure(RequestInterface): ResponseInterface
     */
    private function applyMiddleware(\Closure $handler, array $middleware): \Closure
    {
        foreach (array_reverse($middleware) as $mw) {
            $next = $handler;
            $handler = static fn (RequestInterface $req): ResponseInterface => $mw instanceof Middleware
                ? $mw->handle($req, $next)
                : $mw($req, $next);
        }

        return $handler;
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

        return [] === $merged ? [] : [$key => $merged];
    }
}
