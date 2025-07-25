<?php

declare(strict_types=1);

namespace Anthropic\Models\ImageBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Base64ImageSource;
use Anthropic\Models\URLImageSource;

/**
 * @phpstan-type source_alias = Base64ImageSource|URLImageSource
 */
final class Source implements ConverterSource
{
    use Union;

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
            'base64' => Base64ImageSource::class, 'url' => URLImageSource::class,
        ];
    }
}
