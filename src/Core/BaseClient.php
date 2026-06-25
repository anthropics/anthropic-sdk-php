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
     *
     * @return list<\Anthropic\Middleware>
     */
    protected function backendMiddleware(): array
    {
        return [];
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
        $naive = ($opts->initialRetryDelay ?? RequestOptions::DEFAULT_INITIAL_RETRY_DELAY) * $scale * $jitter;

        return max(0.0, min($naive, $opts->maxRetryDelay ?? RequestOptions::DEFAULT_MAX_RETRY_DELAY));
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
        $defaultTransporter = $opts->transporter;
        $streamingTransporter = $opts->streamingTransporter ?? $defaultTransporter;
        assert(null !== $opts->streamFactory && null !== $defaultTransporter && null !== $streamingTransporter);

        /** @var RequestInterface */
        $req = $req->withHeader('X-Stainless-Retry-Count', strval($retryCount));
        $req = Util::withSetBody($opts->streamFactory, req: $req, body: $data);

        // The innermost step: per-backend signing and the actual HTTP
        // send. Middleware wraps around this, so request modifications it
        // makes are signed by transformRequest() here, per attempt.
        $sendRequest = function (RequestInterface $req) use ($defaultTransporter, $streamingTransporter): ResponseInterface {
            // Rewind the request body when a prior send consumed it — a
            // custom-retry middleware calling callNext more than once, or
            // stream reuse across SDK retries/redirects — so the full body
            // is re-sent and per-attempt signing hashes it from the start.
            $body = $req->getBody();
            if ($body->isSeekable() && 0 !== $body->tell()) {
                $body->rewind();
            }

            $req = $this->transformRequest($req);

            $transporter = Util::isStreamingRequest($req) ? $streamingTransporter : $defaultTransporter;

            return $transporter->sendRequest($req);
        };

        // RequestOptions::parse merges by replacement, but middleware
        // stacks compose: request-level middleware runs inside (after)
        // client-level middleware rather than replacing it.
        $middleware = $opts->middleware ?? [];
        $clientMiddleware = $this->options->middleware ?? [];
        if ($middleware !== $clientMiddleware && [] !== $clientMiddleware) {
            $middleware = [...$clientMiddleware, ...$middleware];
        }
        $sendRequest = $this->applyMiddleware($sendRequest, middleware: [...$middleware, ...$this->backendMiddleware()]);

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

            $req = $this->followRedirect($rsp, req: $req);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: $retryCount, redirectCount: ++$redirectCount);
        }

        if ($this->shouldRetry($opts, retryCount: $retryCount, rsp: $rsp, wantsRetryFromException: null !== $middlewareRetry)) {
            $seconds = $this->retryDelay($opts, retryCount: $retryCount, rsp: $rsp);
            $floor = floor($seconds);
            time_nanosleep((int) $floor, nanoseconds: (int) ($seconds - $floor) * 10 ** 9);

            return $this->sendRequest($opts, req: $req, data: $data, retryCount: ++$retryCount, redirectCount: $redirectCount);
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
     * @param list<\Anthropic\Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface> $middleware
     *
     * @return \Closure(RequestInterface): ResponseInterface
     */
    private function applyMiddleware(\Closure $sendRequest, array $middleware): \Closure
    {
        foreach (array_reverse($middleware) as $mw) {
            $next = $sendRequest;
            $sendRequest = $mw instanceof \Anthropic\Middleware
                ? static fn (RequestInterface $req): ResponseInterface => $mw->handle($req, $next)
                : static fn (RequestInterface $req): ResponseInterface => $mw($req, $next);
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

        return [] === $merged ? [] : [$key => $merged];
    }
}
