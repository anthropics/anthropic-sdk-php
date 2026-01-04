<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type ImageBlockParamShape from \Anthropic\Messages\ImageBlockParam
 *
 * @phpstan-type ContentBlockSourceContentShape = TextBlockParamShape|ImageBlockParamShape
 */
final class ContentBlockSourceContent implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['text' => TextBlockParam::class, 'image' => ImageBlockParam::class];
    }
}
