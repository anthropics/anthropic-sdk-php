<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type WebSearchResultBlockParamShape from \Anthropic\Messages\WebSearchResultBlockParam
 * @phpstan-import-type WebSearchToolRequestErrorShape from \Anthropic\Messages\WebSearchToolRequestError
 *
 * @phpstan-type WebSearchToolResultBlockParamContentShape = list<WebSearchResultBlockParamShape>|WebSearchToolRequestErrorShape
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
            new ListOf(WebSearchResultBlockParam::class),
            WebSearchToolRequestError::class,
        ];
    }
}
