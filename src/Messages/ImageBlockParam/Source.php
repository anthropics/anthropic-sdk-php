<?php

declare(strict_types=1);

namespace Anthropic\Messages\ImageBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64ImageSource;
use Anthropic\Messages\URLImageSource;

/**
 * @phpstan-import-type Base64ImageSourceShape from \Anthropic\Messages\Base64ImageSource
 * @phpstan-import-type URLImageSourceShape from \Anthropic\Messages\URLImageSource
 *
 * @phpstan-type SourceShape = Base64ImageSourceShape|URLImageSourceShape
 */
final class Source implements ConverterSource
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
        return [
            'base64' => Base64ImageSource::class, 'url' => URLImageSource::class,
        ];
    }
}
