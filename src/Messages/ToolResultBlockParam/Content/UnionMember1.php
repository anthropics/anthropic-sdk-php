<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\DocumentBlockParam;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\TextBlockParam;

final class UnionMember1 implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'search_result' => SearchResultBlockParam::class,
            'document' => DocumentBlockParam::class,
        ];
    }
}
