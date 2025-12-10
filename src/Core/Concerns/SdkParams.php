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
     * @param array<string, mixed>|RequestOptions|null $options
     *
     * @return array{array<string, mixed>, RequestOptions}
     */
    public static function parseRequest(mixed $params, array|RequestOptions|null $options): array
    {
        $value = is_array($params) ? Util::array_filter_omit($params) : $params;
        $converter = self::converter();
        $state = new DumpState;
        $dumped = (array) Conversion::dump($converter, value: $value, state: $state);
        // @phpstan-ignore-next-line argument.type
        $opts = RequestOptions::parse($options);

        if (!$state->canRetry) {
            $opts->maxRetries = 0;
        }

        // @phpstan-ignore-next-line return.type
        return [$dumped, $opts];
    }
}
