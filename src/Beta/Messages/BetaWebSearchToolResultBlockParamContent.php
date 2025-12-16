<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaWebSearchResultBlockParamShape from \Anthropic\Beta\Messages\BetaWebSearchResultBlockParam
 * @phpstan-import-type BetaWebSearchToolRequestErrorShape from \Anthropic\Beta\Messages\BetaWebSearchToolRequestError
 *
 * @phpstan-type BetaWebSearchToolResultBlockParamContentShape = list<BetaWebSearchResultBlockParamShape>|BetaWebSearchToolRequestErrorShape
 */
final class BetaWebSearchToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            new ListOf(BetaWebSearchResultBlockParam::class),
            BetaWebSearchToolRequestError::class,
        ];
    }
}
