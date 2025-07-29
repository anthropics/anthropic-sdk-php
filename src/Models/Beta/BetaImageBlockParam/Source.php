<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaImageBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Beta\BetaBase64ImageSource;
use Anthropic\Models\Beta\BetaFileImageSource;
use Anthropic\Models\Beta\BetaURLImageSource;

/**
 * @phpstan-type source_alias = BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource
 */
final class Source implements ConverterSource
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
            'base64' => BetaBase64ImageSource::class,
            'url' => BetaURLImageSource::class,
            'file' => BetaFileImageSource::class,
        ];
    }
}
