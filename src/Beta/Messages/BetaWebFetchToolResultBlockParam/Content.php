<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchToolResultBlockParam;

use Anthropic\Beta\Messages\BetaWebFetchBlockParam;
use Anthropic\Beta\Messages\BetaWebFetchToolResultErrorBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaWebFetchToolResultErrorBlockParamShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultErrorBlockParam
 * @phpstan-import-type BetaWebFetchBlockParamShape from \Anthropic\Beta\Messages\BetaWebFetchBlockParam
 *
 * @phpstan-type ContentShape = BetaWebFetchToolResultErrorBlockParamShape|BetaWebFetchBlockParamShape
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
            BetaWebFetchToolResultErrorBlockParam::class,
            BetaWebFetchBlockParam::class,
        ];
    }
}
