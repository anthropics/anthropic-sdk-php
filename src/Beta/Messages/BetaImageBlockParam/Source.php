<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaImageBlockParam;

use Anthropic\Beta\Messages\BetaBase64ImageSource;
use Anthropic\Beta\Messages\BetaFileImageSource;
use Anthropic\Beta\Messages\BetaURLImageSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBase64ImageSourceShape from \Anthropic\Beta\Messages\BetaBase64ImageSource
 * @phpstan-import-type BetaURLImageSourceShape from \Anthropic\Beta\Messages\BetaURLImageSource
 * @phpstan-import-type BetaFileImageSourceShape from \Anthropic\Beta\Messages\BetaFileImageSource
 *
 * @phpstan-type SourceShape = BetaBase64ImageSourceShape|BetaURLImageSourceShape|BetaFileImageSourceShape
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
            'base64' => BetaBase64ImageSource::class,
            'url' => BetaURLImageSource::class,
            'file' => BetaFileImageSource::class,
        ];
    }
}
