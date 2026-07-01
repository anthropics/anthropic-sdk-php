<?php

declare(strict_types=1);

namespace Anthropic\Lib\Middleware;

/**
 * Tracks which fallback a sequence of requests is pinned to.
 *
 * Create one (`new BetaFallbackState`) and pass it to the
 * {@see RefusalFallbackMiddleware} constructor for every sequence of requests
 * that should share the pin — the turns of one conversation, or any wider
 * scope the stickiness should apply to; the middleware mutates it in place
 * when a model refuses.
 */
final class BetaFallbackState
{
    /**
     * Index into the fallback chain the requests are pinned to.
     *
     * `null` (or -1) targets the original request params; the middleware
     * sets it to the index of the fallback that accepted the request.
     */
    public ?int $index = null;
}
