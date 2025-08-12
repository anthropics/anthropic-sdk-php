<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type web_search_tool_result_block_param_content_alias = list<WebSearchResultBlockParam>|WebSearchToolRequestError
 */
final class WebSearchToolResultBlockParamContent implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            new ListOf(WebSearchResultBlockParam::class),
            WebSearchToolRequestError::class,
        ];
    }
}
