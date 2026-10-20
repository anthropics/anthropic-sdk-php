<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackParam;

/**
 * The inference speed mode for the fallback attempt that uses this `fallbacks` entry's `model`. If you leave it out, the attempt runs at `fast` speed only when the request sets `speed` to `fast` and your organization can use fast mode on `model`.
 *
 * Otherwise, or when you set this field to `null`, the attempt runs at `standard` speed.
 *
 * These rules apply with the `server-side-fallback-2026-07-01` beta header.
 */
enum Speed: string
{
    case STANDARD = 'standard';

    case FAST = 'fast';
}
