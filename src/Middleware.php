<?php

declare(strict_types=1);

namespace Anthropic;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * A request/response interceptor, run once per HTTP attempt, inside the
 * client's retry loop.
 *
 * `handle()` receives the request about to be sent and a `$callNext`
 * continuation. Calling `$callNext($request)` runs the rest of the pipeline
 * (any remaining middleware, per-backend request signing/URL-rewriting, and
 * the HTTP transport) and returns the response.
 *
 * `$callNext` returns the {@see ResponseInterface} for *every* HTTP response —
 * it does not throw on non-2xx — so middleware may inspect the status/body and
 * decide what to do. Implementations may also:
 *
 *  - modify the request before forwarding it. PSR-7 messages are immutable, so
 *    derive a new one: `$request->withHeader(...)`, `withoutHeader(...)`,
 *    `withBody(...)`, etc. Modifications are re-signed by `$callNext`.
 *  - short-circuit by returning a response without calling `$callNext`
 *    (e.g. a cache hit).
 *  - call `$callNext` more than once (e.g. custom retry or fallback logic).
 *
 * Plain callables with the same shape are accepted anywhere a `Middleware` is,
 * i.e. `callable(RequestInterface, CallNext): ResponseInterface`.
 *
 * The request/response are PSR-7 (`Psr\Http\Message`), which is exactly the
 * immutable request view + per-status response the interceptor pattern needs;
 * no SDK-specific wrapper types are introduced.
 *
 * Execution model and caveats:
 *
 *  - Middleware runs once per HTTP attempt: inside the retry loop (so it re-runs
 *    on each SDK retry) and again per redirect hop (against the redirected URL,
 *    which may be a different host).
 *  - Credentials are visible. The request already carries the `X-Api-Key` /
 *    `Authorization` header by the time middleware sees it (OAuth tokens and
 *    AWS SigV4 signatures are added later, inside `$callNext`). If you log or
 *    serialize the request, redact these headers.
 *  - On the Bedrock/Vertex/Foundry clients the request you receive already has
 *    the backend host and any per-backend headers; only signing is deferred
 *    into `$callNext`. Don't assume the canonical `api.anthropic.com` host.
 *  - If you read the response body (e.g. for logging), the SDK rewinds seekable
 *    bodies before decoding, so reading a normal JSON response is safe. Do not
 *    consume a streaming (SSE) response body — it is not seekable and reading it
 *    will break downstream parsing.
 *
 * Failures are not swallowed or wrapped:
 *
 *  - A `Psr\Http\Client\ClientExceptionInterface` thrown by `handle()` (or
 *    raised by `$callNext` and left uncaught) is treated as a transport
 *    failure: the SDK surfaces it as
 *    {@see \Anthropic\Core\Exceptions\APIConnectionException}, with the original
 *    throwable available via `getPrevious()`. Connection failures are not
 *    retried by the default retry policy.
 *  - Any other exception propagates to the caller unchanged (same type, not
 *    wrapped). Use its stack trace to identify the offending middleware.
 *
 * @phpstan-type CallNext = \Closure(RequestInterface): ResponseInterface
 */
interface Middleware
{
    /**
     * @param CallNext $callNext
     */
    public function handle(
        RequestInterface $request,
        \Closure $callNext
    ): ResponseInterface;
}
