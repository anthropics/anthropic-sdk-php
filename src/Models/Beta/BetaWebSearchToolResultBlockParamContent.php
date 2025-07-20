<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_web_search_tool_result_block_param_content_alias = list<
 *   BetaWebSearchResultBlockParam
 * >|BetaWebSearchToolRequestError
 */
final class BetaWebSearchToolResultBlockParamContent implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
     */
    public static function variants(): array
    {
        return [
            new ListOf(BetaWebSearchResultBlockParam::class),
            BetaWebSearchToolRequestError::class,
        ];
    }
}
