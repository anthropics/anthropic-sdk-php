<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\ContentBlockParam;

/**
 * @phpstan-import-type ContentBlockParamShape from \Anthropic\Messages\ContentBlockParam
 *
 * @phpstan-type ContentShape = string|list<ContentBlockParamShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(ContentBlockParam::class)];
    }
}
