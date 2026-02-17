<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolSearchToolResultBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ToolSearchToolResultErrorParam;
use Anthropic\Messages\ToolSearchToolSearchResultBlockParam;

/**
 * @phpstan-import-type ToolSearchToolResultErrorParamShape from \Anthropic\Messages\ToolSearchToolResultErrorParam
 * @phpstan-import-type ToolSearchToolSearchResultBlockParamShape from \Anthropic\Messages\ToolSearchToolSearchResultBlockParam
 *
 * @phpstan-type ContentVariants = ToolSearchToolResultErrorParam|ToolSearchToolSearchResultBlockParam
 * @phpstan-type ContentShape = ContentVariants|ToolSearchToolResultErrorParamShape|ToolSearchToolSearchResultBlockParamShape
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
            ToolSearchToolResultErrorParam::class,
            ToolSearchToolSearchResultBlockParam::class,
        ];
    }
}
