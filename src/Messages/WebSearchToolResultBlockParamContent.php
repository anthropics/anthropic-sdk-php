<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type WebSearchResultBlockParamShape from \Anthropic\Messages\WebSearchResultBlockParam
 * @phpstan-import-type WebSearchToolRequestErrorObjectShape from \Anthropic\Messages\WebSearchToolRequestErrorObject
 *
 * @phpstan-type WebSearchToolResultBlockParamContentVariants = list<WebSearchResultBlockParam>|WebSearchToolRequestErrorObject
 * @phpstan-type WebSearchToolResultBlockParamContentShape = WebSearchToolResultBlockParamContentVariants|list<WebSearchResultBlockParamShape>|WebSearchToolRequestErrorObjectShape
 */
final class WebSearchToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            WebSearchToolRequestErrorObject::class,
            new ListOf(WebSearchResultBlockParam::class),
        ];
    }
}
