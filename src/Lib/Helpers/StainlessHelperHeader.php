<?php

declare(strict_types=1);

namespace Anthropic\Lib\Helpers;

/**
 * Single source of truth for the `x-stainless-helper` telemetry header — the
 * key, the closed value vocabulary shared verbatim across SDKs, and the
 * comma-append merge.
 *
 * @internal
 */
final class StainlessHelperHeader
{
    /**
     * Telemetry header naming the SDK helper(s) a request came from. Always
     * this lowercase form; header lookups are case-insensitive but a single
     * canonical casing keeps every call site greppable.
     */
    public const HEADER = 'x-stainless-helper';

    // Closed value vocabulary. Existing values keep their original spellings —
    // telemetry consumers match on them, so renames lose history. New tags are
    // hyphenated lowercase.
    public const BETA_TOOL_RUNNER = 'BetaToolRunner';

    public const FALLBACK_REFUSAL_MIDDLEWARE = 'fallback-refusal-middleware';

    /**
     * The {@see HEADER} value to set after appending `$value` to whatever is
     * already present in `$headers` — existing tags keep their position, the
     * new tag goes at the end, duplicates are dropped, joined as one
     * comma-separated string. The backend logs the header as one opaque
     * string, so a second header line or a clobbered value loses data.
     *
     * @param array<string, string|int|list<string|int>|null> $headers
     */
    public static function mergedValue(array $headers, string $value): string
    {
        $tokens = [];
        foreach ($headers as $name => $existing) {
            if (0 !== strcasecmp((string) $name, self::HEADER)) {
                continue;
            }
            foreach (is_array($existing) ? $existing : [$existing] as $line) {
                foreach (explode(',', (string) $line) as $token) {
                    $token = trim($token);
                    if ('' !== $token && !in_array($token, $tokens, true)) {
                        $tokens[] = $token;
                    }
                }
            }
        }
        if (!in_array($value, $tokens, true)) {
            $tokens[] = $value;
        }

        return implode(', ', $tokens);
    }
}
