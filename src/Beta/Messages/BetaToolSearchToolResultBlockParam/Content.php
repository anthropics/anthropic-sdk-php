<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam;

use Anthropic\Beta\Messages\BetaToolSearchToolResultErrorParam;
use Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaToolSearchToolResultErrorParamShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultErrorParam
 * @phpstan-import-type BetaToolSearchToolSearchResultBlockParamShape from \Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlockParam
 *
 * @phpstan-type ContentShape = BetaToolSearchToolResultErrorParamShape|BetaToolSearchToolSearchResultBlockParamShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaToolSearchToolResultErrorParam::class,
            BetaToolSearchToolSearchResultBlockParam::class,
        ];
    }
}
