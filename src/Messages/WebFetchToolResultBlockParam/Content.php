<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchToolResultBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\WebFetchBlockParam;
use Anthropic\Messages\WebFetchToolResultErrorBlockParam;

/**
 * @phpstan-import-type WebFetchToolResultErrorBlockParamShape from \Anthropic\Messages\WebFetchToolResultErrorBlockParam
 * @phpstan-import-type WebFetchBlockParamShape from \Anthropic\Messages\WebFetchBlockParam
 *
 * @phpstan-type ContentVariants = WebFetchToolResultErrorBlockParam|WebFetchBlockParam
 * @phpstan-type ContentShape = ContentVariants|WebFetchToolResultErrorBlockParamShape|WebFetchBlockParamShape
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
            WebFetchToolResultErrorBlockParam::class, WebFetchBlockParam::class,
        ];
    }
}
