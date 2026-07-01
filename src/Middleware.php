<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\RetryableException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * A request/response interceptor, run once per HTTP attempt — inside the
 * client's retry loop, so it re-runs on every SDK retry and redirect hop.
 *
 * `$callNext($request)` runs the rest of the pipeline (remaining middleware,
 * per-backend signing/URL rewriting, the HTTP transport) and returns the
 * response for *every* HTTP status — it does not throw on non-2xx. A
 * middleware may modify the request before forwarding (PSR-7 messages are
 * immutable; modifications are re-signed inside `$callNext`), short-circuit
 * by returning a response without calling `$callNext`, or call `$callNext`
 * more than once for custom retries or fallbacks.
 *
 * Plain callables with the same signature as {@see Middleware::handle()} are
 * accepted anywhere a `Middleware` is, so one-off middleware can be written
 * inline.
 *
 * The pipeline always invokes middleware with a third argument: the
 * attempt's fully merged {@see RequestOptions}. A middleware that reads
 * request-level options declares an optional third
 * parameter — `?RequestOptions $options = null` — which is a compatible
 * implementation of this interface; one declared with two parameters simply
 * never sees the argument. A middleware whose third parameter serves any
 * other purpose must be rewritten: the pipeline fills that slot on every
 * invocation (a mismatched type throws at request time). The argument list
 * is frozen: future per-attempt context is added as new `RequestOptions`
 * keys, never as another parameter.
 *
 * Treat the options object as read-only. It is the request's live options,
 * shared by every middleware and every retry/redirect attempt: writes to
 * fields the client still consults (e.g. `maxRetries`, `middleware`) change
 * in-flight behavior, while writes to fields already consumed when the
 * request was built (e.g. `extraHeaders`) are silently inert.
 *
 * Contract:
 *
 *  - Credentials are visible: the request already carries `X-Api-Key` /
 *    `Authorization` (OAuth and SigV4 are added later, inside `$callNext`).
 *    Redact when logging.
 *  - A middleware that reads the response body must restore it before
 *    returning: rewind a seekable body, or return
 *    `$response->withBody(...)` with a fresh body. Streaming (SSE) bodies
 *    are not seekable — pass those through unread.
 *  - A thrown `Psr\Http\Client\ClientExceptionInterface` surfaces as
 *    {@see APIConnectionException} (original via `getPrevious()`); any other
 *    exception propagates to the caller unchanged.
 *  - Throwing {@see RetryableException} opts the current attempt back into the
 *    SDK retry policy: it is retried with the usual backoff, subject to
 *    `maxRetries`, and once retries are exhausted it surfaces to the caller
 *    as-is.
 */
interface Middleware
{
    /**
     * @param \Closure(RequestInterface): ResponseInterface $callNext
     */
    public function handle(
        RequestInterface $request,
        \Closure $callNext
    ): ResponseInterface;
}
