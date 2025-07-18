<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\DumpState;
use Anthropic\RequestOptions;

/**
 * @internal
 */
trait Params
{
    /**
     * @param null|array<string, mixed>|self           $params
     * @param null|array<string, mixed>|RequestOptions $options
     *
     * @return array{array<string, mixed>, array{
     *     timeout: float,
     *     maxRetries: int,
     *     initialRetryDelay: float,
     *     maxRetryDelay: float,
     *     extraHeaders: list<string>,
     *     extraQueryParams: list<string>,
     *     extraBodyParams: list<string>,
     * }}
     */
    public static function parseRequest(null|array|self $params, null|array|RequestOptions $options): array
    {
        $converter = self::converter();
        $state = new DumpState();
        $dumped = (array) Conversion::dump($converter, value: $params, state: $state);
        $opts = RequestOptions::parse($options); // @phpstan-ignore-line

        if (!$state->canRetry) {
            $opts->maxRetries = 0;
        }

        $opt = $opts->__serialize();
        if (empty($opt['extraHeaders'])) {
            unset($opt['extraHeaders']);
        }
        if (empty($opt['extraQueryParams'])) {
            unset($opt['extraQueryParams']);
        }
        if (empty($opt['extraBodyParams'])) {
            unset($opt['extraBodyParams']);
        }

        return [$dumped, $opt]; // @phpstan-ignore-line
    }
}
