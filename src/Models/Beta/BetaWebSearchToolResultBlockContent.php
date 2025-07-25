<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_web_search_tool_result_block_content_alias = BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>
 */
final class BetaWebSearchToolResultBlockContent implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            BetaWebSearchToolResultError::class,
            new ListOf(BetaWebSearchResultBlock::class),
        ];
    }
}
