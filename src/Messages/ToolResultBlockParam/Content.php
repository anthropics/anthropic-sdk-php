<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ToolResultBlockParam\Content\UnionMember1;

/**
 * @phpstan-type content_alias = string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(UnionMember1::class)];
    }
}
