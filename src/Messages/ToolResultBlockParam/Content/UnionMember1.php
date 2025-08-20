<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\TextBlockParam;

/**
 * @phpstan-type union_member1_alias = TextBlockParam|ImageBlockParam|SearchResultBlockParam
 */
final class UnionMember1 implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'search_result' => SearchResultBlockParam::class,
        ];
    }
}
