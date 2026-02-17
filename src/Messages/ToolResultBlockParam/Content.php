<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\DocumentBlockParam;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ToolReferenceBlockParam;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolResultBlockParam\Content\Content as ContentShape1
 *
 * @phpstan-type ContentVariants = string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam|ToolReferenceBlockParam>
 * @phpstan-type ContentShape = ContentVariants|list<ContentShape1>
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
            'string',
            new ListOf(
                Content\Content::class
            ),
        ];
    }
}
