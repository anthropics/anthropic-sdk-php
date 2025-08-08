<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolResultBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\SearchResultBlockParam;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ToolResultBlockParam\Content\UnionMember1;

/**
 * @phpstan-type content_alias = string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam>
 */
final class Content implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(UnionMember1::class)];
    }
}
