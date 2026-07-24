<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackCreditTokenParam;

/**
 * How a failing token affects the retry. `strict` (the default, and the bare-string behavior): a failing redemption is a 400 and the retry is not served. `best_effort`: the retry is served either way — a token-layer failure no longer rejects the request; the retry proceeds at normal price and the outcome is reported on the response's `usage.fallback_credit`. Two failures stay hard in both modes: a malformed token, and combining `fallback_credit_token` with `fallbacks`.
 */
enum Mode: string
{
    case STRICT = 'strict';

    case BEST_EFFORT = 'best_effort';
}
