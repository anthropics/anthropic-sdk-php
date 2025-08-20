<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type web_search_tool_result_block_param_content_alias = list<WebSearchResultBlockParam>|WebSearchToolRequestError
 */
final class WebSearchToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            new ListOf(WebSearchResultBlockParam::class),
            WebSearchToolRequestError::class,
        ];
    }
}
