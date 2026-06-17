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
