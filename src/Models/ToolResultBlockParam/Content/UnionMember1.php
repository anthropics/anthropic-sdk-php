<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\SearchResultBlockParam;
use Anthropic\Models\TextBlockParam;

/**
 * @phpstan-type union_member1_alias = TextBlockParam|ImageBlockParam|SearchResultBlockParam
 */
final class UnionMember1 implements ConverterSource
{
    use Union;

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
