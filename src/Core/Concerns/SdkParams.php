<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\DumpState;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;

/**
 * @internal
 */
trait SdkParams
{
    /**
     * @param array<string, mixed>|self|null           $params
     * @param array<string, mixed>|RequestOptions|null $options
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
    public static function parseRequest(array|self|null $params, array|RequestOptions|null $options): array
    {
        $value = is_array($params) ? Util::array_filter_omit($params) : $params;
        $converter = self::converter();
        $state = new DumpState;
        $dumped = (array) Conversion::dump($converter, value: $value, state: $state);
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
