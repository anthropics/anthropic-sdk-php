<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolSearchToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ToolSearchToolResultErrorObject;
use Anthropic\Messages\ToolSearchToolSearchResultBlock;

/**
 * @phpstan-import-type ToolSearchToolResultErrorObjectShape from \Anthropic\Messages\ToolSearchToolResultErrorObject
 * @phpstan-import-type ToolSearchToolSearchResultBlockShape from \Anthropic\Messages\ToolSearchToolSearchResultBlock
 *
 * @phpstan-type ContentVariants = ToolSearchToolResultErrorObject|ToolSearchToolSearchResultBlock
 * @phpstan-type ContentShape = ContentVariants|ToolSearchToolResultErrorObjectShape|ToolSearchToolSearchResultBlockShape
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
            ToolSearchToolResultErrorObject::class,
            ToolSearchToolSearchResultBlock::class,
        ];
    }
}
