<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaClearToolUses20250919Edit;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
 *
 * @phpstan-type ClearToolInputsShape = bool|list<string>
 */
final class ClearToolInputs implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['bool', new ListOf('string')];
    }
}
