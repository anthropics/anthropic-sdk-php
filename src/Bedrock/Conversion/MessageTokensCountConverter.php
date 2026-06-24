<?php

declare(strict_types=1);

namespace Anthropic\Bedrock\Conversion;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\CoerceState;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\DumpState;
use Anthropic\Messages\MessageTokensCount;

/**
 * Converts Bedrock count-tokens responses into the SDK model shape.
 *
 * @internal
 */
final class MessageTokensCountConverter implements Converter
{
    public function coerce(mixed $value, CoerceState $state): mixed
    {
        if (is_array($value) && array_key_exists('inputTokens', $value) && is_array($value['inputTokens'])) {
            $value = ['input_tokens' => $value['inputTokens']] + $value;
            unset($value['inputTokens']);
        }

        return Conversion::coerce(MessageTokensCount::class, value: $value, state: $state);
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        return Conversion::dump(MessageTokensCount::class, value: $value, state: $state);
    }
}
