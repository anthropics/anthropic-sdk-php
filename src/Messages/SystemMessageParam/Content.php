<?php

declare(strict_types=1);

namespace Anthropic\Messages\SystemMessageParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\TextBlockParam;

/**
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 *
 * @phpstan-type ContentVariants = string|list<TextBlockParam>
 * @phpstan-type ContentShape = ContentVariants|list<TextBlockParamShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(TextBlockParam::class)];
    }
}
