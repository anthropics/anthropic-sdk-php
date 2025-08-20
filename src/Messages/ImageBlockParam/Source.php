<?php

declare(strict_types=1);

namespace Anthropic\Messages\ImageBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64ImageSource;
use Anthropic\Messages\URLImageSource;

/**
 * @phpstan-type source_alias = Base64ImageSource|URLImageSource
 */
final class Source implements ConverterSource
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
            'base64' => Base64ImageSource::class, 'url' => URLImageSource::class,
        ];
    }
}
